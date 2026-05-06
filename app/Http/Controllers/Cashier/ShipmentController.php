<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\Rate;
use App\Models\ShipmentTracking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::with(['sender', 'receiver', 'originBranch', 'destinationBranch', 'payment'])
            ->where(function($q) {
                $q->where('origin_branch_id', Auth::user()->branch_id)
                  ->orWhere('current_branch_id', Auth::user()->branch_id)
                  ->orWhere('destination_branch_id', Auth::user()->branch_id);
            });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('tracking_number', 'like', '%' . $request->search . '%');
        }

        $shipments = $query->latest()->paginate(15)->withQueryString();
        return view('cashier.shipments.index', compact('shipments'));
    }

    public function scan(Request $request)
    {
        $request->validate(['tracking_number' => 'required|string']);
        $shipment = Shipment::where('tracking_number', $request->tracking_number)->first();
        
        if (!$shipment) {
            return back()->with('error', 'Resi tidak ditemukan. Pastikan nomor resi benar.');
        }
        
        return redirect()->route('cashier.shipments.show', $shipment);
    }

    public function create()
    {
        $customers  = Customer::orderBy('name')->get();
        $branches   = Branch::orderBy('city')->get();
        $rates      = Rate::orderBy('origin_city')->get();
        $userBranch = Auth::user()->branch;

        return view('cashier.shipments.create', compact('customers', 'branches', 'rates', 'userBranch'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_id'              => 'required|exists:customers,id',
            'receiver_id'            => 'required|exists:customers,id',
            'origin_branch_id'       => 'required|exists:branches,id',
            'destination_branch_id'  => 'required|exists:branches,id|different:origin_branch_id',
            'rate_id'                => 'required|exists:rates,id',
            'shipment_date'          => 'required|date',
            'items'                  => 'required|array|min:1',
            'items.*.item_name'      => 'required|string|max:255',
            'items.*.quantity'       => 'required|integer|min:1',
            'items.*.weight'         => 'required|numeric|min:0.01',
            'payer_type'             => 'required|in:sender,receiver',
        ]);

        $shipment = DB::transaction(function () use ($validated) {
            $rate         = Rate::findOrFail($validated['rate_id']);
            $total_weight = collect($validated['items'])->sum('weight');
            $total_price  = $total_weight * $rate->price_per_kg;

            $shipment = Shipment::create([
                'tracking_number'       => Shipment::generateTrackingNumber(),
                'sender_id'             => $validated['sender_id'],
                'receiver_id'           => $validated['receiver_id'],
                'origin_branch_id'      => Auth::user()->branch_id,
                'current_branch_id'     => Auth::user()->branch_id,
                'destination_branch_id' => $validated['destination_branch_id'],
                'payer_type'            => $validated['payer_type'],
                'rate_id'               => $validated['rate_id'],
                'total_weight'          => $total_weight,
                'total_price'           => $total_price,
                'status'                => 'pending',
                'shipment_date'         => $validated['shipment_date'],
            ]);

            foreach ($validated['items'] as $item) {
                ShipmentItem::create([
                    'shipment_id' => $shipment->id,
                    'item_name'   => $item['item_name'],
                    'quantity'    => $item['quantity'],
                    'weight'      => $item['weight'],
                ]);
            }

            return $shipment;
        });

        return redirect()
            ->route('cashier.shipments.show', $shipment)
            ->with('success', 'Shipment berhasil dibuat! Silakan proses pembayaran.');
    }

    public function show(Shipment $shipment)
    {
        $shipment->load(['sender', 'receiver', 'originBranch', 'destinationBranch', 'rate', 'items', 'payment', 'trackings']);
        return view('cashier.shipments.show', compact('shipment'));
    }

    public function printWaybill(Shipment $shipment)
    {
        $shipment->load(['sender', 'receiver', 'originBranch', 'destinationBranch', 'items', 'payment']);
        
        $logoPath = public_path('images/logo_light.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = base64_encode(file_get_contents($logoPath));
        }

        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($shipment->tracking_number, $generator::TYPE_CODE_128));

        $qrcode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(150)->margin(0)->generate($shipment->tracking_number));

        $pdf = Pdf::loadView('pdf.shipment-waybill', compact('shipment', 'barcode', 'qrcode', 'logoBase64'))
                  ->setPaper('a5', 'landscape');

        return $pdf->stream('Waybill_' . $shipment->tracking_number . '.pdf');
    }

    public function storeCustomer(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:50',
            'phone'   => 'required|string|max:15',
            'address' => 'required|string',
            'city'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:customers,email',
        ]);

        $customer = Customer::create($validated);

        return response()->json([
            'id'    => $customer->id,
            'name'  => $customer->name,
            'phone' => $customer->phone,
        ]);
    }

    public function receive(Shipment $shipment)
    {
        if (!in_array($shipment->status, ['picked_up', 'in_transit'])) {
            return back()->with('error', 'Paket tidak dapat diterima karena belum dalam perjalanan.');
        }

        if ($shipment->status === 'in_transit' && $shipment->current_branch_id === Auth::user()->branch_id) {
            return back()->with('error', 'Paket ini baru saja diberangkatkan dari cabang Anda. Tidak dapat diterima lagi.');
        }

        $shipment->update([
            'status'            => 'arrived_at_branch',
            'current_branch_id' => Auth::user()->branch_id
        ]);

        ShipmentTracking::create([
            'shipment_id' => $shipment->id,
            'branch_id'   => Auth::user()->branch_id,
            'location'    => Auth::user()->branch->name . ' (' . Auth::user()->branch->city . ')',
            'description' => 'Paket telah diterima di cabang ' . Auth::user()->branch->name,
            'status'      => 'arrived_at_branch',
            'tracked_at'  => now(),
        ]);

        return back()->with('success', 'Paket berhasil diterima di cabang.');
    }

    public function payCash(Shipment $shipment)
    {
        Payment::updateOrCreate(
            ['shipment_id' => $shipment->id],
            [
                'amount'         => $shipment->total_price,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
                'payment_date'   => now(),
            ]
        );

        return back()->with('success', 'Pembayaran tunai berhasil dicatat.');
    }

    public function checkPaymentStatus(Shipment $shipment)
    {
        $shipment->load('payment');
        $payment = $shipment->payment;
        
        return response()->json([
            'status'  => $payment->payment_status ?? 'pending',
            'paid_at' => $payment && $payment->payment_date ? Carbon::parse($payment->payment_date)->format('d M Y H:i') : '-',
            'badge'   => $payment->status_badge ?? 'bg-yellow-100 text-yellow-800'
        ]);
    }
}
