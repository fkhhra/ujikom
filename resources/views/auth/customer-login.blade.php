@extends('layouts.app')
@section('title', 'Login - Trivo')
@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <div class="hidden lg:flex lg:w-1/2 bg-[#1a2b5c] items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-20 -left-20 w-80 h-80 bg-[#6abf2e] rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-60 h-60 bg-[#6abf2e] rounded-full"></div>
        </div>
        <div class="text-center relative z-10 px-10">
            <img src="{{ asset('images/branding/logo.png') }}" alt="Trivo" class="h-16 mx-auto mb-6 brightness-200">
            <h2 class="text-3xl font-extrabold text-white mb-3">Kirim Paket Lebih Mudah</h2>
            <p class="text-gray-300 text-sm leading-relaxed">Lacak paket, kelola pengiriman, dan nikmati kemudahan bertransaksi bersama Trivo.</p>
        </div>
    </div>
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            <div class="lg:hidden text-center mb-8">
                <img src="{{ asset('images/branding/logo.png') }}" alt="Trivo" class="h-12 mx-auto">
            </div>
            <h1 class="text-2xl font-extrabold text-[#1a2b5c] mb-1">Masuk ke Akun</h1>
            <p class="text-gray-500 text-sm mb-7">Selamat datang kembali di Trivo</p>

            @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('customer.login.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full border @error('email') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none"
                        placeholder="email@kamu.com">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none"
                        placeholder="••••••••">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-[#1a2b5c] border-gray-300 rounded">
                    <label for="remember" class="ms-2 text-sm text-gray-600">Ingat saya</label>
                </div>
                <button type="submit" class="w-full bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold py-3 rounded-lg text-sm transition-all mt-2">
                    Masuk
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-5">
                Belum punya akun?
                <a href="{{ route('customer.register') }}" class="text-[#1a2b5c] font-semibold hover:text-[#6abf2e]">Daftar sekarang</a>
            </p>
            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-gray-600">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection
