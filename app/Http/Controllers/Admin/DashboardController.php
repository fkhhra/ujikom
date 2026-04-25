<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Customer;
use App\Models\User;
use App\Models\Payment;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isManager = $user->role === 'manager';
        $branchId = $user->branch_id;

        $shipmentQuery = Shipment::query();
        $paymentQuery = Payment::where('payment_status', 'paid');

        if ($isManager) {
            $shipmentQuery->where(function($q) use ($branchId) {
                $q->where('origin_branch_id', $branchId)
                  ->orWhere('destination_branch_id', $branchId)
                  ->orWhere('current_branch_id', $branchId);
            });
            
            $paymentQuery->whereHas('shipment', function($q) use ($branchId) {
                $q->where('origin_branch_id', $branchId)
                  ->orWhere('destination_branch_id', $branchId)
                  ->orWhere('current_branch_id', $branchId);
            });
        }

        $totalShipments   = (clone $shipmentQuery)->count();
        $totalCustomers   = Customer::count();
        $totalCouriers    = User::where('role', 'courier')
                                ->when($isManager, fn($q) => $q->where('branch_id', $branchId))
                                ->count();
        $totalBranches    = Branch::count();

        $totalRevenue     = (clone $paymentQuery)->sum('amount');
        $monthRevenue     = (clone $paymentQuery)->whereMonth('payment_date', Carbon::now()->month)->sum('amount');

        $pendingShipments    = (clone $shipmentQuery)->where('status', 'pending')->count();
        $inTransitShipments  = (clone $shipmentQuery)->whereIn('status', ['picked_up', 'in_transit', 'arrived_at_branch', 'out_for_delivery'])->count();
        $deliveredShipments  = (clone $shipmentQuery)->where('status', 'delivered')->count();
        $cancelledShipments  = (clone $shipmentQuery)->where('status', 'cancelled')->count();

        $recentShipments = (clone $shipmentQuery)->with(['sender', 'receiver', 'originBranch', 'destinationBranch', 'payment'])
                                   ->latest()
                                   ->take(10)
                                   ->get();

        Carbon::setLocale('id');
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            
            $monthPaymentQuery = Payment::where('payment_status', 'paid')
                                        ->whereYear('payment_date', $month->year)
                                        ->whereMonth('payment_date', $month->month);

            if ($isManager) {
                $monthPaymentQuery->whereHas('shipment', function($q) use ($branchId) {
                    $q->where('origin_branch_id', $branchId)
                      ->orWhere('destination_branch_id', $branchId)
                      ->orWhere('current_branch_id', $branchId);
                });
            }

            $chartData[] = [
                'label'      => $month->translatedFormat('M y'),
                'full_label' => $month->translatedFormat('F Y'),
                'revenue'    => $monthPaymentQuery->sum('amount'),
            ];
        }

        return view('admin.dashboard.index', compact(
            'totalShipments', 'totalCustomers', 'totalCouriers', 'totalBranches',
            'totalRevenue', 'monthRevenue', 'pendingShipments', 'inTransitShipments',
            'deliveredShipments', 'cancelledShipments', 'recentShipments', 'chartData'
        ));
    }
}
