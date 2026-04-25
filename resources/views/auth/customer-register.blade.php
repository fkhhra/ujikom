@extends('layouts.app')
@section('title', 'Daftar - Trivo')
@section('content')
<div class="min-h-screen bg-gray-50 flex">
    <div class="hidden lg:flex lg:w-1/2 bg-[#1a2b5c] items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-20 -left-20 w-80 h-80 bg-[#6abf2e] rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-60 h-60 bg-[#6abf2e] rounded-full"></div>
        </div>
        <div class="text-center relative z-10 px-10">
            <img src="{{ asset('images/branding/logo.png') }}" alt="Trivo" class="h-16 mx-auto mb-6 brightness-200">
            <h2 class="text-3xl font-extrabold text-white mb-3">Bergabung dengan Trivo</h2>
            <p class="text-gray-300 text-sm leading-relaxed">Daftar gratis dan mulai kirim paket ke seluruh Indonesia dengan mudah, cepat, dan terpercaya.</p>
        </div>
    </div>
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 overflow-y-auto">
        <div class="w-full max-w-md">
            <div class="lg:hidden text-center mb-8">
                <img src="{{ asset('images/branding/logo.png') }}" alt="Trivo" class="h-12 mx-auto">
            </div>
            <h1 class="text-2xl font-extrabold text-[#1a2b5c] mb-1">Buat Akun Baru</h1>
            <p class="text-gray-500 text-sm mb-7">Isi data diri Anda untuk mendaftar</p>

            <form method="POST" action="{{ route('customer.register.post') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full border @error('name') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none"
                            placeholder="Nama lengkap Anda">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border @error('email') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none"
                            placeholder="email@kamu.com">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                        <input type="password" name="password" required
                            class="w-full border @error('password') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none"
                            placeholder="Min. 8 karakter">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none"
                            placeholder="Ulangi password">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                            class="w-full border @error('phone') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none"
                            placeholder="08xxxxxxxxxx">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota</label>
                        <input type="text" name="city" value="{{ old('city') }}" required
                            class="w-full border @error('city') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none"
                            placeholder="Jakarta">
                        @error('city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat</label>
                        <input type="text" name="address" value="{{ old('address') }}" required
                            class="w-full border @error('address') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none"
                            placeholder="Jl. ...">
                        @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <button type="submit" class="w-full bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold py-3 rounded-lg text-sm transition-all mt-2">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-5">
                Sudah punya akun?
                <a href="{{ route('customer.login') }}" class="text-[#1a2b5c] font-semibold hover:text-[#6abf2e]">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
