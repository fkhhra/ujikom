<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withTrashed()->with('branch');

        if (Auth::user()->role === 'manager') {
            $query->where('branch_id', Auth::user()->branch_id);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users    = $query->latest()->paginate(15)->withQueryString();
        
        $branches = Auth::user()->role === 'manager' 
            ? Branch::where('id', Auth::user()->branch_id)->get() 
            : Branch::all();

        return view('admin.users.index', compact('users', 'branches'));
    }

    public function create()
    {
        $branches = Auth::user()->role === 'manager' 
            ? Branch::where('id', Auth::user()->branch_id)->get() 
            : Branch::all();

        $vehicles = Auth::user()->role === 'manager'
            ? Vehicle::where('branch_id', Auth::user()->branch_id)->get()
            : Vehicle::all();
            
        return view('admin.users.create', compact('branches', 'vehicles'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'manager') {
            if ($request->branch_id != Auth::user()->branch_id) {
                return back()->with('error', 'Anda hanya bisa menambah user di cabang sendiri.');
            }
            if ($request->role === 'admin') {
                return back()->with('error', 'Manager tidak bisa membuat user Admin.');
            }
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8',
            'role'      => 'required|in:admin,cashier,courier,manager',
            'branch_id' => 'required|exists:branches,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if (Auth::user()->role === 'manager') {
            if ($user->branch_id != Auth::user()->branch_id) {
                return redirect()->route('admin.users.index')->with('error', 'Akses ditolak.');
            }
            if ($user->role === 'manager' && $user->id != Auth::id()) {
                return redirect()->route('admin.users.index')->with('error', 'Manager tidak bisa mengubah Manager lain.');
            }
        }

        $branches = Auth::user()->role === 'manager' 
            ? Branch::where('id', Auth::user()->branch_id)->get() 
            : Branch::all();

        $vehicles = Auth::user()->role === 'manager'
            ? Vehicle::where('branch_id', Auth::user()->branch_id)->get()
            : Vehicle::all();

        return view('admin.users.edit', compact('user', 'branches', 'vehicles'));
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()->role === 'manager') {
            if ($user->branch_id != Auth::user()->branch_id) {
                return redirect()->route('admin.users.index')->with('error', 'Akses ditolak.');
            }
            if ($user->role === 'manager' && $user->id != Auth::id()) {
                return redirect()->route('admin.users.index')->with('error', 'Manager tidak bisa mengubah Manager lain.');
            }
            if ($request->branch_id != Auth::user()->branch_id) {
                return back()->with('error', 'Anda hanya bisa mengatur user di cabang sendiri.');
            }
            if ($request->role === 'admin') {
                return back()->with('error', 'Manager tidak bisa membuat role Admin.');
            }
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:admin,cashier,courier,manager',
            'branch_id' => 'required|exists:branches,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        if (Auth::user()->role === 'admin' && $user->role === 'admin') {
            return back()->with('error', 'Super Admin tidak bisa menonaktifkan Admin lain.');
        }

        if (Auth::user()->role === 'manager') {
            if ($user->branch_id != Auth::user()->branch_id) {
                return back()->with('error', 'Akses ditolak.');
            }
            if ($user->role === 'manager' && $user->id !== Auth::id()) {
                return back()->with('error', 'Manager tidak bisa menonaktifkan Manager lain.');
            }
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dinonaktifkan.');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        
        if (Auth::user()->role === 'admin' && $user->role === 'admin') {
            return back()->with('error', 'Super Admin tidak bisa mengaktifkan Admin lain.');
        }

        if (Auth::user()->role === 'manager') {
            if ($user->branch_id != Auth::user()->branch_id) {
                return back()->with('error', 'Akses ditolak.');
            }
            if ($user->role === 'manager' && $user->id !== Auth::id()) {
                return back()->with('error', 'Manager tidak bisa mengaktifkan Manager lain.');
            }
        }

        $user->restore();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diaktifkan kembali.');
    }
}
