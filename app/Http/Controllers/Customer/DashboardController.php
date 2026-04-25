<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $customerId = Auth::guard('customer')->id();
        $tab = request('tab', 'outgoing');

        $query = Shipment::with(['originBranch', 'destinationBranch', 'payment', 'sender', 'receiver'])
                          ->latest();

        if ($tab === 'incoming') {
            $query->where('receiver_id', $customerId);
        } else {
            $query->where('sender_id', $customerId);
        }

        $shipments = $query->paginate(10)->withQueryString();

        $totalSent      = Shipment::where('sender_id', $customerId)->count();
        $totalReceived  = Shipment::where('receiver_id', $customerId)->count();
        $activeShipments = Shipment::where('sender_id', $customerId)
                                   ->whereIn('status', ['pending', 'picked_up', 'in_transit', 'arrived_at_branch', 'out_for_delivery'])
                                   ->count();

        return view('customer.dashboard', compact('shipments', 'totalSent', 'totalReceived', 'activeShipments', 'tab'));
    }

    public function track(Shipment $shipment)
    {
        $customerId = Auth::guard('customer')->id();

        abort_unless(
            $shipment->sender_id === $customerId || $shipment->receiver_id === $customerId,
            403
        );

        $shipment->load(['sender', 'receiver', 'originBranch', 'destinationBranch', 'courier', 'items', 'payment', 'trackings']);
        return view('customer.tracking', compact('shipment'));
    }
}
