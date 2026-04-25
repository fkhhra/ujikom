<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function index(Request $request)
    {
        $query = Rate::query();

        if ($request->filled('origin_city')) {
            $query->where('origin_city', $request->origin_city);
        }
        if ($request->filled('destination_city')) {
            $query->where('destination_city', $request->destination_city);
        }

        $rates  = $query->orderBy('origin_city')->paginate(20)->withQueryString();
        $cities = Rate::select('origin_city')->distinct()->orderBy('origin_city')->pluck('origin_city');

        return view('admin.rates.index', compact('rates', 'cities'));
    }

    public function create()
    {
        $cities = Rate::select('origin_city')->distinct()->orderBy('origin_city')->pluck('origin_city');
        return view('admin.rates.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin_city'      => 'required|string|max:255',
            'destination_city' => 'required|string|max:255|different:origin_city',
            'price_per_kg'     => 'required|numeric|min:0',
            'estimated_days'   => 'required|integer|min:1',
        ]);

        Rate::updateOrCreate(
            ['origin_city' => $validated['origin_city'], 'destination_city' => $validated['destination_city']],
            ['price_per_kg' => $validated['price_per_kg'], 'estimated_days' => $validated['estimated_days']]
        );

        return redirect()->route('admin.rates.index')->with('success', 'Tarif berhasil disimpan.');
    }

    public function edit(Rate $rate)
    {
        return view('admin.rates.edit', compact('rate'));
    }

    public function update(Request $request, Rate $rate)
    {
        $validated = $request->validate([
            'price_per_kg'   => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
        ]);

        $rate->update($validated);
        return redirect()->route('admin.rates.index')->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy(Rate $rate)
    {
        $rate->delete();
        return redirect()->route('admin.rates.index')->with('success', 'Tarif berhasil dihapus.');
    }
}
