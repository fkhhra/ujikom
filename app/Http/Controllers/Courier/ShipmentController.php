<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\ShipmentTracking;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::with(['sender', 'receiver', 'originBranch', 'destinationBranch'])
                         ->where('courier_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $shipments = $query->latest()->paginate(15)->withQueryString();

        $activeCount    = Shipment::where('courier_id', Auth::id())->whereIn('status', ['picked_up', 'in_transit', 'arrived_at_branch', 'out_for_delivery'])->count();
        $deliveredCount = Shipment::where('courier_id', Auth::id())->where('status', 'delivered')->count();

        return view('courier.shipments.index', compact('shipments', 'activeCount', 'deliveredCount'));
    }

    private function getAllowedTransitions($currentStatus): array
    {
        $map = [
            'pending'           => ['picked_up'],
            'picked_up'         => ['in_transit', 'out_for_delivery'],
            'in_transit'        => ['arrived_at_branch', 'out_for_delivery'],
            'arrived_at_branch' => ['in_transit', 'out_for_delivery'],
            'out_for_delivery'  => ['delivered'],
        ];

        return $map[$currentStatus] ?? [];
    }

    public function show(Shipment $shipment)
    {
        abort_unless($shipment->courier_id === Auth::id(), 403);
        $shipment->load(['sender', 'receiver', 'originBranch', 'destinationBranch', 'items', 'payment', 'trackings']);
        
        $branches = Branch::orderBy('city')->get();
        
        $defaultLocationId = $shipment->current_branch_id ?? $shipment->origin_branch_id;

        $allowedNextStates = $this->getAllowedTransitions($shipment->status);
        $statusOptions = collect($allowedNextStates)->map(function($status) {
            $labels = [
                'picked_up'         => 'Dijemput',
                'in_transit'        => 'Dalam Perjalanan',
                'arrived_at_branch' => 'Tiba di Cabang',
                'out_for_delivery'  => 'Sedang Diantar',
                'delivered'         => 'Terkirim',
            ];
            return ['value' => $status, 'label' => $labels[$status] ?? ucfirst($status)];
        });

        return view('courier.shipments.show', compact('shipment', 'branches', 'statusOptions', 'defaultLocationId'));
    }

    public function updateStatus(Request $request, Shipment $shipment)
    {
        abort_unless($shipment->courier_id === Auth::id(), 403);

        $allowedTransitions = $this->getAllowedTransitions($shipment->status);

        $request->validate([
            'status'      => ['required', 'in:' . implode(',', $allowedTransitions)],
            'location_id' => 'required|exists:branches,id',
            'description' => 'required|string|max:500',
            'images'      => 'nullable|array|max:5',
            'images.*'    => 'image|max:3072',
        ]);

        $branch = Branch::findOrFail($request->location_id);
        
        if ($request->status === 'delivered') {
            $locationLabel = "Diterima oleh Penerima (" . ($shipment->receiver->city ?? $branch->city) . ")";
        } else {
            $locationLabel = $branch->city . " (" . $branch->name . ")";
        }

        $updateData = ['status' => $request->status];

        if ($request->status === 'arrived_at_branch') {
            $updateData['current_branch_id'] = $branch->id;
        }

        $shipment->update($updateData);

        if ($request->status === 'delivered' && $shipment->payer_type === 'receiver') {
            $shipment->payment()->updateOrCreate(
                ['shipment_id' => $shipment->id],
                [
                    'amount'         => $shipment->total_price,
                    'payment_method' => 'cash',
                    'payment_status' => 'paid',
                    'payment_date'   => now(),
                ]
            );
        }

        $tracking = ShipmentTracking::create([
            'shipment_id' => $shipment->id,
            'branch_id'   => $branch->id,
            'location'    => $locationLabel,
            'description' => $request->description,
            'status'      => $request->status,
            'tracked_at'  => now(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('trackings/' . $shipment->tracking_number, 'public');
                $tracking->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('courier.shipments.show', $shipment)->with('success', 'Status berhasil diperbarui.');
    }

    public function dashboard()
    {
        $courierId = Auth::id();

        $activeShipments = Shipment::with(['sender', 'receiver', 'destinationBranch'])
                                   ->where('courier_id', $courierId)
                                   ->whereIn('status', ['picked_up', 'in_transit', 'arrived_at_branch', 'out_for_delivery'])
                                   ->get();

        $todayDelivered = Shipment::where('courier_id', $courierId)
                                  ->where('status', 'delivered')
                                  ->whereDate('updated_at', today())
                                  ->count();

        $totalDelivered = Shipment::where('courier_id', $courierId)->where('status', 'delivered')->count();

        return view('courier.dashboard', compact('activeShipments', 'todayDelivered', 'totalDelivered'));
    }
}
