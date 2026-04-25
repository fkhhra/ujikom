<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $branchId = Auth::user()->branch_id;

        $todayShipments = Shipment::where('origin_branch_id', $branchId)
                                  ->whereDate('shipment_date', Carbon::today())
                                  ->count();

        $pendingPayments = Shipment::where('origin_branch_id', $branchId)
                                   ->whereHas('payment', fn($q) => $q->where('payment_status', 'pending'))
                                   ->orWhere(function ($q) use ($branchId) {
                                       $q->where('origin_branch_id', $branchId)->doesntHave('payment');
                                   })
                                   ->count();

        $todayRevenue = Payment::where('payment_status', 'paid')
                               ->whereDate('payment_date', Carbon::today())
                               ->whereHas('shipment', fn($q) => $q->where('origin_branch_id', $branchId))
                               ->sum('amount');

        $recentShipments = Shipment::with(['sender', 'receiver', 'payment'])
                                   ->where(function($q) use ($branchId) {
                                       $q->where('origin_branch_id', $branchId)
                                         ->orWhere('current_branch_id', $branchId)
                                         ->orWhere('destination_branch_id', $branchId);
                                   })
                                   ->latest()
                                   ->take(8)
                                   ->get();

        return view('cashier.dashboard', compact('todayShipments', 'pendingPayments', 'todayRevenue', 'recentShipments'));
    }
}
