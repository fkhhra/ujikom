<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with('branch');

        if (Auth::user()->role === 'manager') {
            $query->where('branch_id', Auth::user()->branch_id);
        }

        if ($request->filled('search')) {
            $query->where('plate_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('ownership')) {
            $query->where('ownership', $request->ownership);
        }

        $vehicles = $query->latest()->paginate(15)->withQueryString();
        
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $branches = Auth::user()->role === 'manager' 
            ? Branch::where('id', Auth::user()->branch_id)->get() 
            : Branch::all();
            
        return view('admin.vehicles.create', compact('branches'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'manager') {
            if ($request->branch_id != Auth::user()->branch_id) {
                return back()->with('error', 'Anda hanya bisa menambah kendaraan di cabang sendiri.');
            }
        }

        $validated = $request->validate([
            'plate_number' => 'required|string|max:255|unique:vehicles,plate_number',
            'type'         => 'required|in:motor,mobil,truck',
            'ownership'    => 'required|in:company,personal',
            'branch_id'    => 'required|exists:branches,id',
        ]);

        Vehicle::create($validated);

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function edit(Vehicle $vehicle)
    {
        if (Auth::user()->role === 'manager' && $vehicle->branch_id != Auth::user()->branch_id) {
            return redirect()->route('admin.vehicles.index')->with('error', 'Akses ditolak.');
        }

        $branches = Auth::user()->role === 'manager' 
            ? Branch::where('id', Auth::user()->branch_id)->get() 
            : Branch::all();

        return view('admin.vehicles.edit', compact('vehicle', 'branches'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        if (Auth::user()->role === 'manager') {
            if ($vehicle->branch_id != Auth::user()->branch_id || $request->branch_id != Auth::user()->branch_id) {
                return redirect()->route('admin.vehicles.index')->with('error', 'Akses ditolak.');
            }
        }

        $validated = $request->validate([
            'plate_number' => 'required|string|max:255|unique:vehicles,plate_number,' . $vehicle->id,
            'type'         => 'required|in:motor,mobil,truck',
            'ownership'    => 'required|in:company,personal',
            'branch_id'    => 'required|exists:branches,id',
        ]);

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Vehicle $vehicle)
    {
        if (Auth::user()->role === 'manager' && $vehicle->branch_id != Auth::user()->branch_id) {
            return back()->with('error', 'Akses ditolak.');
        }

        if ($vehicle->couriers()->count() > 0) {
            return back()->with('error', 'Kendaraan tidak bisa dihapus karena sedang digunakan oleh kurir.');
        }

        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
