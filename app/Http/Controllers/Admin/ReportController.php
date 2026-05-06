<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date_format:d-m-Y',
            'end_date'   => 'required|date_format:d-m-Y|after_or_equal:start_date',
            'status'     => 'nullable|string',
        ], [
            'after_or_equal' => ':attribute tidak boleh sebelum :date.',
            'date_format'    => 'Format :attribute harus :format.',
        ], [
            'start_date' => 'Tanggal Mulai',
            'end_date'   => 'Tanggal Selesai',
        ]);

        $query = Shipment::with(['sender', 'receiver', 'originBranch', 'destinationBranch', 'payment']);

        if (Auth::user()->role === 'manager') {
            $query->where(function($q) {
                $q->where('origin_branch_id', Auth::user()->branch_id)
                  ->orWhere('destination_branch_id', Auth::user()->branch_id)
                  ->orWhere('current_branch_id', Auth::user()->branch_id);
            });
        }

        $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay();
        $endDate   = Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay();

        $query->whereBetween('shipment_date', [$startDate, $endDate]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $shipments = $query->latest()->get();

        $start = $startDate->translatedFormat('d F Y');
        $end   = $endDate->translatedFormat('d F Y');

        $data = [
            'period_start' => $start,
            'period_end'   => $end,
            'shipments'    => $shipments,
        ];

        $pdf = Pdf::loadView('pdf.report', $data)
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Pengiriman_' . now()->format('YmdHis') . '.pdf');
    }
}
