<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:' . ($user instanceof Customer ? 'customers' : 'users') . ',email,' . $user->id,
            'photo' => 'nullable|image|max:2048',
        ];

        if ($user instanceof Customer) {
            $rules['phone']   = 'nullable|string|max:20';
            $rules['address'] = 'nullable|string';
            $rules['city']    = 'nullable|string|max:100';
        }

        $request->validate($rules);

        $data = $request->only(['name', 'phone', 'address', 'city']);
        
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            
            $path = $request->file('photo')->store('photos/' . ($user instanceof Customer ? 'customers' : 'staff'), 'public');
            $data['photo'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function removePhoto()
    {
        $user = Auth::user();
        
        if ($user->photo) {
            if (Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            
            $user->update(['photo' => null]);
            return back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return back()->with('error', 'Tidak ada foto untuk dihapus.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => 'required|confirmed|min:8',
        ], [
            'current_password.current_password' => 'Kata sandi saat ini tidak cocok.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min' => 'Kata sandi minimal 8 karakter.'
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Kata sandi berhasil diubah.');
    }
}
