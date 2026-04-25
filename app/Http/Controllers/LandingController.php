<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;
use App\Models\Branch;
use App\Models\Shipment;

class LandingController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        $cities = Rate::select('origin_city')->distinct()->orderBy('origin_city')->pluck('origin_city');
        return view('landing.index', compact('branches', 'cities'));
    }

    public function trackingPage(Request $request)
    {
        $trackingNumber = strtoupper(trim($request->query('resi')));

        if ($trackingNumber) {
            $shipment = Shipment::with([
                'sender', 'receiver', 'originBranch', 'destinationBranch',
                'courier', 'rate', 'items', 'payment', 'trackings'
            ])->where('tracking_number', $trackingNumber)->first();

            if ($shipment) {
                return view('landing.tracking.show', compact('shipment'));
            }

            return redirect()->route('tracking', ['resi' => $trackingNumber])
                ->withErrors(['resi' => 'Nomor resi tidak ditemukan.']);
        }

        return view('landing.tracking.index');
    }

    public function track(Request $request)
    {
        $request->validate(['tracking_number' => 'required|string']);
        $tracking_number = strtoupper(trim($request->tracking_number));

        $shipment = Shipment::with([
            'sender', 'receiver', 'originBranch', 'destinationBranch',
            'courier', 'rate', 'items', 'payment', 'trackings'
        ])->where('tracking_number', $tracking_number)->first();

        if (!$shipment) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Nomor resi tidak ditemukan.'], 404);
            }
            return back()->withErrors(['tracking_number' => 'Nomor resi tidak ditemukan.'])->withInput();
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return view('landing.tracking.show', compact('shipment'));
    }

    public function checkRate(Request $request)
    {
        $request->validate([
            'origin_city'      => 'required|string',
            'destination_city' => 'required|string',
            'weight'           => 'required|numeric|min:0.1|max:1000',
        ]);

        $rate = Rate::where('origin_city', $request->origin_city)
                    ->where('destination_city', $request->destination_city)
                    ->first();

        if (!$rate) {
            return response()->json(['error' => 'Rute tidak tersedia.'], 404);
        }

        $total = $rate->price_per_kg * $request->weight;

        return response()->json([
            'price_per_kg'    => $rate->price_per_kg,
            'estimated_days'  => $rate->estimated_days,
            'total'           => $total,
            'weight'          => $request->weight,
        ]);
    }
}
