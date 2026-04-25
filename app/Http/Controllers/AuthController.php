<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Auth\Events\Verified;

class AuthController extends Controller
{
    public function showStaffLogin()
    {
        if ($redirect = $this->redirectIfAuthenticated()) return $redirect;
        return view('auth.staff-login');
    }

    public function staffLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();
            return $this->redirectByRole($user)->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function showCustomerLogin()
    {
        if ($redirect = $this->redirectIfAuthenticated()) return $redirect;
        return view('auth.customer-login');
    }

    public function customerLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('customer.dashboard'))->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function showCustomerRegister()
    {
        if ($redirect = $this->redirectIfAuthenticated()) return $redirect;
        return view('auth.customer-register');
    }

    public function customerRegister(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:50',
            'email'    => 'required|email|unique:customers,email',
            'password' => 'required|min:8|confirmed',
            'phone'    => 'required|string|max:15|unique:customers,phone',
            'address'  => 'required|string',
            'city'     => 'required|string',
        ]);

        $customer = Customer::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
            'phone'    => $validated['phone'],
            'address'  => $validated['address'],
            'city'     => $validated['city'],
        ]);

        $customer->sendEmailVerificationNotification();

        Auth::guard('customer')->login($customer);
        return redirect()->route('customer.verification.notice')->with('success', 'Registrasi berhasil! Silakan verifikasi email Anda.');
    }

    public function verifyCustomerEmail(Request $request, $id, $hash)
    {
        $user = Customer::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Tautan verifikasi tidak valid.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('customer.dashboard');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->route('customer.dashboard')->with('success', 'Email berhasil diverifikasi!');
    }

    public function resendCustomerVerificationEmail(Request $request)
    {
        if ($request->user('customer')->hasVerifiedEmail()) {
            return redirect()->route('customer.dashboard');
        }

        $request->user('customer')->sendEmailVerificationNotification();
        return back()->with('success', 'Tautan verifikasi baru telah dikirim!');
    }

    public function logout(Request $request)
    {
        $redirectRoute = 'home';

        if (Auth::guard('customer')->check()) {
            $redirectRoute = 'customer.login';
        } elseif (Auth::guard('web')->check()) {
            $redirectRoute = 'staff.login';
        }

        Auth::guard('web')->logout();
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($redirectRoute)->with('success', 'Berhasil keluar. Sampai jumpa lagi!');
    }

    private function redirectIfAuthenticated()
    {
        if (Auth::guard('web')->check()) {
            return $this->redirectByRole(Auth::guard('web')->user());
        }
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard');
        }
        return null;
    }

    private function redirectByRole($user)
    {
        return match($user->role) {
            'admin', 'manager' => redirect()->route('admin.dashboard'),
            'cashier'          => redirect()->route('cashier.dashboard'),
            'courier'          => redirect()->route('courier.dashboard'),
            default            => redirect()->route('home'),
        };
    }
}
