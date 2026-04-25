@extends('layouts.app')

@section('title', 'Lacak Paket - Trivo')

@section('content')

<nav class="fixed w-full z-50 top-0 bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('images/branding/logo.png') }}" alt="Trivo" class="h-10">
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-[#1a2b5c] transition-colors">← Beranda</a>
                <a href="{{ route('customer.login') }}" class="text-sm font-semibold bg-[#1a2b5c] text-white px-4 py-2 rounded-lg hover:bg-[#111e42] transition-all">Masuk</a>
            </div>
        </div>
    </div>
</nav>

<div class="min-h-screen bg-gray-50 pt-16">
    <div class="bg-[#1a2b5c] py-14">
        <div class="max-w-2xl mx-auto px-6 text-center">
            <h1 class="text-3xl font-extrabold text-white mb-2">Lacak Paket Anda</h1>
            <p class="text-gray-300 text-sm">Masukkan nomor resi untuk melihat status pengiriman</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-6 -mt-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
                {{ $errors->first('resi') }}
            </div>
            @endif
            <form action="{{ route('track') }}" method="POST">
                @csrf
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Resi</label>
                <div class="flex gap-3 flex-col sm:flex-row">
                    <input type="text" name="tracking_number" value="{{ request('resi') }}" placeholder="Masukkan nomor resi..."
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none uppercase" required>
                    <button type="submit" class="bg-[#1a2b5c] hover:bg-[#111e42] text-white font-semibold px-6 py-3 rounded-lg text-sm transition-all whitespace-nowrap">
                        Lacak Sekarang
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center text-gray-400 text-sm">
            <p>Belum memiliki akun? <a href="{{ route('customer.register') }}" class="text-[#1a2b5c] font-semibold hover:text-[#6abf2e]">Daftar sekarang</a> untuk pelacakan lebih mudah.</p>
        </div>
    </div>
</div>
@endsection
