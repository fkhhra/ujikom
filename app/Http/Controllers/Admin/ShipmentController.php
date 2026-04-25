<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::with(['sender', 'receiver', 'originBranch', 'destinationBranch', 'courier', 'payment']);

        if (Auth::user()->role === 'manager') {
            $query->where(function($q) {
                $q->where('origin_branch_id', Auth::user()->branch_id)
                  ->orWhere('destination_branch_id', Auth::user()->branch_id)
                  ->orWhere('current_branch_id', Auth::user()->branch_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('tracking_number', 'like', '%' . $request->search . '%');
        }

        $shipments = $query->latest()->paginate(15)->withQueryString();
        return view('admin.shipments.index', compact('shipments'));
    }

    public function show(Shipment $shipment)
    {
        $shipment->load(['sender', 'receiver', 'originBranch', 'destinationBranch', 'courier', 'rate', 'items', 'payment', 'trackings']);
        $couriers = User::where('role', 'courier')->with('vehicle')->get();
        return view('admin.shipments.show', compact('shipment', 'couriers'));
    }

    public function assignCourier(Request $request, Shipment $shipment)
    {
        if (!in_array($shipment->status, ['pending', 'arrived_at_branch'])) {
            return back()->with('error', 'Kurir hanya dapat ditugaskan saat paket berstatus Menunggu atau Tiba di Cabang.');
        }

        if (Auth::user()->role === 'manager' && $shipment->current_branch_id !== Auth::user()->branch_id && $shipment->status !== 'pending') {
            return back()->with('error', 'Anda hanya berhak menugaskan kurir untuk paket di cabang Anda.');
        }

        $request->validate(['courier_id' => 'required|exists:users,id']);

        $shipment->update(['courier_id' => $request->courier_id]);
        return redirect()->route('admin.shipments.show', $shipment)->with('success', 'Kurir berhasil ditugaskan.');
    }

    public function cancel(Shipment $shipment)
    {
        $shipment->update(['status' => 'cancelled']);
        return back()->with('success', 'Pengiriman dibatalkan.');
    }
}
