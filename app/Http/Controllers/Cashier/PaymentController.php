<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['shipment.sender', 'shipment.receiver', 'shipment.destinationBranch'])
            ->whereHas('shipment', function($q) {
                $q->where('origin_branch_id', Auth::user()->branch_id)
                  ->where('payer_type', 'sender');
            });

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();
        return view('cashier.payments.index', compact('payments'));
    }

    public function create(Shipment $shipment)
    {
        abort_unless(
            $shipment->origin_branch_id === Auth::user()->branch_id && 
            $shipment->payer_type === 'sender', 
            403
        );

        $shipment->load(['sender', 'receiver', 'payment']);
        return view('cashier.payments.create', compact('shipment'));
    }

    public function store(Request $request, Shipment $shipment)
    {
        abort_unless(
            $shipment->origin_branch_id === Auth::user()->branch_id && 
            $shipment->payer_type === 'sender', 
            403
        );

        $request->validate([
            'payment_method' => 'required|in:cash',
        ]);

        $payment = Payment::updateOrCreate(
            ['shipment_id' => $shipment->id],
            [
                'amount'         => $shipment->total_price,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
                'payment_date'   => now(),
            ]
        );

        return redirect()->route('cashier.payments.index')->with('success', 'Pembayaran tunai berhasil dicatat.');
    }

    public function printReceipt(Payment $payment)
    {
        $shipment = $payment->shipment;
        $shipment->load(['sender', 'receiver', 'originBranch', 'destinationBranch', 'items', 'payment']);
        
        $logoPath = public_path('images/logo_dark.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = base64_encode(file_get_contents($logoPath));
        }

        $itemCount = $shipment->items->count() ?: 1;
        $dynamicHeight = 280 + ($itemCount * 20) + 40;
        
        $customPaper = array(0, 0, 164.4, $dynamicHeight);
        $pdf = Pdf::loadView('pdf.payment-receipt', compact('shipment', 'logoBase64'))
                  ->setPaper($customPaper);

        return $pdf->stream('Receipt_' . $shipment->tracking_number . '.pdf');
    }
}
