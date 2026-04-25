@extends('layouts.app')

@section('title', 'Trivo - Solusi Pengiriman Terpercaya')

@section('content')

{{-- NAVBAR --}}
<nav class="fixed w-full z-50 top-0 bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('images/branding/logo.png') }}" alt="Trivo" class="h-10">
            </a>
            <div class="hidden md:flex items-center gap-6">
                <a href="#layanan" class="text-sm font-medium text-gray-600 hover:text-[#1a2b5c] transition-colors">Layanan</a>
                <a href="#cek-tarif" class="text-sm font-medium text-gray-600 hover:text-[#1a2b5c] transition-colors">Cek Tarif</a>
                <a href="{{ route('tracking') }}" class="text-sm font-medium text-gray-600 hover:text-[#1a2b5c] transition-colors">Lacak Paket</a>
                <a href="#cabang" class="text-sm font-medium text-gray-600 hover:text-[#1a2b5c] transition-colors">Cabang</a>
                <a href="{{ route('customer.login') }}" class="text-sm font-semibold text-[#1a2b5c] border border-[#1a2b5c] px-4 py-2 rounded-lg hover:bg-[#1a2b5c] hover:text-white transition-all">Masuk</a>
                <a href="{{ route('customer.register') }}" class="text-sm font-semibold bg-[#6abf2e] text-white px-4 py-2 rounded-lg hover:bg-[#4e9020] transition-all">Daftar</a>
            </div>
            <button data-collapse-toggle="mobile-menu" type="button" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
    <div class="hidden md:hidden" id="mobile-menu">
        <div class="px-4 py-3 space-y-2 border-t border-gray-100">
            <a href="#layanan" class="block py-2 text-sm text-gray-600">Layanan</a>
            <a href="#cek-tarif" class="block py-2 text-sm text-gray-600">Cek Tarif</a>
            <a href="{{ route('tracking') }}" class="block py-2 text-sm text-gray-600">Lacak Paket</a>
            <a href="#cabang" class="block py-2 text-sm text-gray-600">Cabang</a>
            <a href="{{ route('customer.login') }}" class="block py-2 text-sm font-semibold text-[#1a2b5c]">Masuk</a>
            <a href="{{ route('customer.register') }}" class="block py-2 text-sm font-semibold text-[#6abf2e]">Daftar</a>
        </div>
    </div>
</nav>

{{-- HERO CAROUSEL --}}
<section class="pt-16">
    <div id="hero-carousel" class="relative w-full" data-carousel="slide" data-carousel-interval="5000">
        <div class="relative h-[500px] md:h-[600px] overflow-hidden">
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('images/carousel/carousel-1.webp') }}" class="absolute block w-full h-full object-cover" alt="Trivo Pengiriman">
                <div class="absolute inset-0 bg-gradient-to-r from-[#1a2b5c]/80 to-[#1a2b5c]/30 flex items-center">
                    <div class="max-w-7xl mx-auto px-6 w-full">
                        <div class="max-w-xl">
                            <span class="inline-block bg-[#6abf2e] text-white text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-wider">Terpercaya & Cepat</span>
                            <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Kirim Paket ke Seluruh Indonesia</h1>
                            <p class="text-gray-200 text-lg mb-6">Solusi logistik andalan bisnis Anda. Aman, cepat, dan bisa dilacak real-time.</p>
                            <div class="flex gap-3 flex-wrap">
                                <a href="#cek-tarif" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-6 py-3 rounded-lg transition-all">Cek Tarif Sekarang</a>
                                <a href="{{ route('tracking') }}" class="bg-white/20 hover:bg-white/30 text-white font-semibold px-6 py-3 rounded-lg transition-all border border-white/40 backdrop-blur-sm">Lacak Paket</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('images/carousel/carousel-2.webp') }}" class="absolute block w-full h-full object-cover" alt="Trivo Tim">
                <div class="absolute inset-0 bg-gradient-to-r from-[#1a2b5c]/80 to-[#1a2b5c]/30 flex items-center">
                    <div class="max-w-7xl mx-auto px-6 w-full">
                        <div class="max-w-xl">
                            <span class="inline-block bg-[#6abf2e] text-white text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-wider">Tim Profesional</span>
                            <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Kurir Berpengalaman Siap Melayani</h1>
                            <p class="text-gray-200 text-lg mb-6">Tim kami terlatih untuk memastikan setiap paket sampai dengan selamat dan tepat waktu.</p>
                            <div class="flex gap-3 flex-wrap">
                                <a href="{{ route('customer.register') }}" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-6 py-3 rounded-lg transition-all">Daftar Sekarang</a>
                                <a href="#layanan" class="bg-white/20 hover:bg-white/30 text-white font-semibold px-6 py-3 rounded-lg transition-all border border-white/40 backdrop-blur-sm">Lihat Layanan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('images/carousel/carousel-3.webp') }}" class="absolute block w-full h-full object-cover" alt="Trivo Packaging">
                <div class="absolute inset-0 bg-gradient-to-r from-[#1a2b5c]/80 to-[#1a2b5c]/30 flex items-center">
                    <div class="max-w-7xl mx-auto px-6 w-full">
                        <div class="max-w-xl">
                            <span class="inline-block bg-[#6abf2e] text-white text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-wider">Pengemasan Aman</span>
                            <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Paket Anda Aman di Tangan Kami</h1>
                            <p class="text-gray-200 text-lg mb-6">Proses pengemasan standar tinggi memastikan barang Anda tiba dalam kondisi sempurna.</p>
                            <div class="flex gap-3 flex-wrap">
                                <a href="#cek-tarif" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-6 py-3 rounded-lg transition-all">Cek Tarif Sekarang</a>
                                <a href="#cabang" class="bg-white/20 hover:bg-white/30 text-white font-semibold px-6 py-3 rounded-lg transition-all border border-white/40 backdrop-blur-sm">Temukan Cabang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 backdrop-blur-sm border border-white/40 transition-all">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/></svg>
            </span>
        </button>
        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 backdrop-blur-sm border border-white/40 transition-all">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
            </span>
        </button>
    </div>
</section>

{{-- STATS STRIP --}}
<section class="bg-[#1a2b5c] py-6">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <p class="text-2xl font-extrabold text-[#6abf2e]">{{ $branches->count() }}+</p>
                <p class="text-sm text-gray-300 mt-1">Cabang Aktif</p>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-[#6abf2e]">100K+</p>
                <p class="text-sm text-gray-300 mt-1">Paket Terkirim</p>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-[#6abf2e]">34</p>
                <p class="text-sm text-gray-300 mt-1">Provinsi Dijangkau</p>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-[#6abf2e]">98%</p>
                <p class="text-sm text-gray-300 mt-1">Kepuasan Pelanggan</p>
            </div>
        </div>
    </div>
</section>

{{-- QUICK TRACK --}}
<section class="py-10 bg-gray-50 border-b border-gray-200">
    <div class="max-w-3xl mx-auto px-6">
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
            <h2 class="text-lg font-bold text-[#1a2b5c] mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#6abf2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Lacak Paket Anda
            </h2>
            <form action="{{ route('track') }}" method="POST" class="flex gap-3 flex-col sm:flex-row">
                @csrf
                <input type="text" name="tracking_number" placeholder="Masukkan nomor resi..." required
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none">
                <button type="submit" class="bg-[#1a2b5c] hover:bg-[#111e42] text-white font-semibold px-6 py-3 rounded-lg text-sm transition-all whitespace-nowrap">
                    Lacak Sekarang
                </button>
            </form>
            @error('tracking_number')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- LAYANAN --}}
<section id="layanan" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-[#6abf2e] font-semibold text-sm uppercase tracking-wider">Apa yang Kami Tawarkan</span>
            <h2 class="text-3xl font-extrabold text-[#1a2b5c] mt-2">Layanan Unggulan Trivo</h2>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">Kami menyediakan berbagai solusi pengiriman yang sesuai dengan kebutuhan Anda</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="group bg-gray-50 hover:bg-[#1a2b5c] rounded-2xl p-6 border border-gray-100 transition-all duration-300 cursor-default">
                <div class="w-12 h-12 bg-[#6abf2e]/15 group-hover:bg-[#6abf2e]/20 rounded-xl flex items-center justify-center mb-4 transition-all">
                    <svg class="w-6 h-6 text-[#6abf2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-[#1a2b5c] group-hover:text-white text-lg mb-2 transition-colors">Pengiriman Reguler</h3>
                <p class="text-gray-500 group-hover:text-gray-300 text-sm leading-relaxed transition-colors">Pengiriman ekonomis dengan estimasi 2-5 hari kerja ke seluruh wilayah Indonesia.</p>
            </div>
            <div class="group bg-gray-50 hover:bg-[#1a2b5c] rounded-2xl p-6 border border-gray-100 transition-all duration-300 cursor-default">
                <div class="w-12 h-12 bg-[#6abf2e]/15 group-hover:bg-[#6abf2e]/20 rounded-xl flex items-center justify-center mb-4 transition-all">
                    <svg class="w-6 h-6 text-[#6abf2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <h3 class="font-bold text-[#1a2b5c] group-hover:text-white text-lg mb-2 transition-colors">Pelacakan Real-time</h3>
                <p class="text-gray-500 group-hover:text-gray-300 text-sm leading-relaxed transition-colors">Pantau status paket Anda kapan saja dan di mana saja melalui nomor resi.</p>
            </div>
            <div class="group bg-gray-50 hover:bg-[#1a2b5c] rounded-2xl p-6 border border-gray-100 transition-all duration-300 cursor-default">
                <div class="w-12 h-12 bg-[#6abf2e]/15 group-hover:bg-[#6abf2e]/20 rounded-xl flex items-center justify-center mb-4 transition-all">
                    <svg class="w-6 h-6 text-[#6abf2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-[#1a2b5c] group-hover:text-white text-lg mb-2 transition-colors">Pembayaran Fleksibel</h3>
                <p class="text-gray-500 group-hover:text-gray-300 text-sm leading-relaxed transition-colors">Bayar via transfer, QRIS, atau tunai di cabang terdekat dengan mudah.</p>
            </div>
        </div>
    </div>
</section>

{{-- CEK TARIF --}}
<section id="cek-tarif" class="py-16 bg-gray-50">
    <div class="max-w-3xl mx-auto px-6">
        <div class="text-center mb-10">
            <span class="text-[#6abf2e] font-semibold text-sm uppercase tracking-wider">Estimasi Biaya</span>
            <h2 class="text-3xl font-extrabold text-[#1a2b5c] mt-2">Cek Tarif Pengiriman</h2>
            <p class="text-gray-500 mt-2 text-sm">Ketahui estimasi biaya pengiriman sebelum mengirim paket Anda</p>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
            <form id="rate-form" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota Asal</label>
                        <select name="origin_city" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none bg-white">
                            <option value="">Pilih kota asal...</option>
                            @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota Tujuan</label>
                        <select name="destination_city" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none bg-white">
                            <option value="">Pilih kota tujuan...</option>
                            @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Berat Paket (kg)</label>
                    <input type="number" name="weight" step="0.1" min="0.1" placeholder="Contoh: 2.5" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none">
                </div>
                <button type="submit" class="w-full bg-[#1a2b5c] hover:bg-[#111e42] text-white font-semibold py-3 rounded-lg text-sm transition-all">
                    Cek Tarif
                </button>
            </form>

            <div id="rate-result" class="hidden mt-5 p-4 bg-[#f0f7e8] border border-[#6abf2e]/30 rounded-xl">
                <p class="text-xs font-semibold text-[#4e9020] uppercase tracking-wider mb-3">Hasil Estimasi</p>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-xs text-gray-500">Tarif / kg</p>
                        <p class="font-bold text-[#1a2b5c] text-base" id="result-per-kg">-</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Estimasi</p>
                        <p class="font-bold text-[#1a2b5c] text-base" id="result-days">-</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Total Biaya</p>
                        <p class="font-bold text-[#6abf2e] text-base" id="result-total">-</p>
                    </div>
                </div>
            </div>
            <div id="rate-error" class="hidden mt-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-sm text-red-600" id="rate-error-msg">Rute tidak tersedia.</p>
            </div>
        </div>
    </div>
</section>

{{-- CABANG --}}
<section id="cabang" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-10">
            <span class="text-[#6abf2e] font-semibold text-sm uppercase tracking-wider">Jaringan Kami</span>
            <h2 class="text-3xl font-extrabold text-[#1a2b5c] mt-2">Cabang Trivo</h2>
            <p class="text-gray-500 mt-2 text-sm">Temukan cabang terdekat untuk pengiriman dan pengambilan paket</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($branches as $branch)
            <div class="bg-gray-50 hover:bg-[#f0f7e8] border border-gray-100 hover:border-[#6abf2e]/30 rounded-xl p-4 transition-all">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 bg-[#1a2b5c] rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-[#6abf2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-[#1a2b5c] text-sm">{{ $branch->name }}</p>
                        <p class="text-gray-500 text-xs mt-0.5">{{ $branch->city }}</p>
                        @if($branch->phone)
                        <p class="text-[#6abf2e] text-xs mt-1 font-medium">{{ $branch->phone }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-[#1a2b5c]">
    <div class="max-w-3xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-extrabold text-white mb-4">Siap Mengirim Paket Anda?</h2>
        <p class="text-gray-300 mb-8">Daftar sekarang dan nikmati kemudahan pengiriman dengan Trivo.</p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('customer.register') }}" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-8 py-3 rounded-lg transition-all">Daftar Gratis</a>
            <a href="{{ route('tracking') }}" class="bg-white/15 hover:bg-white/25 text-white font-semibold px-8 py-3 rounded-lg transition-all border border-white/30">Lacak Paket</a>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="bg-[#111e42] text-gray-400 py-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
                <img src="{{ asset('images/branding/logo.png') }}" alt="Trivo" class="h-10 mb-3 brightness-200">
                <p class="text-sm leading-relaxed">Solusi pengiriman terpercaya untuk bisnis dan personal di seluruh Indonesia.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3 text-sm">Tautan Cepat</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#layanan" class="hover:text-[#6abf2e] transition-colors">Layanan</a></li>
                    <li><a href="#cek-tarif" class="hover:text-[#6abf2e] transition-colors">Cek Tarif</a></li>
                    <li><a href="{{ route('tracking') }}" class="hover:text-[#6abf2e] transition-colors">Lacak Paket</a></li>
                    <li><a href="#cabang" class="hover:text-[#6abf2e] transition-colors">Cabang</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3 text-sm">Akun</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('customer.login') }}" class="hover:text-[#6abf2e] transition-colors">Login Pelanggan</a></li>
                    <li><a href="{{ route('customer.register') }}" class="hover:text-[#6abf2e] transition-colors">Daftar Pelanggan</a></li>
                    <li><a href="{{ route('staff.login') }}" class="hover:text-[#6abf2e] transition-colors">Login Staff</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 pt-6 text-center text-xs">
            <p>&copy; {{ date('Y') }} Trivo. Semua hak dilindungi.</p>
        </div>
    </div>
</footer>

@push('scripts')
<script>
document.getElementById('rate-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = e.target;
    const data = new FormData(form);
    const resultEl = document.getElementById('rate-result');
    const errorEl = document.getElementById('rate-error');
    resultEl.classList.add('hidden');
    errorEl.classList.add('hidden');

    try {
        const response = await fetch('{{ route("check-rate") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: data
        });
        const json = await response.json();

        if (!response.ok) {
            document.getElementById('rate-error-msg').textContent = json.error || 'Rute tidak tersedia.';
            errorEl.classList.remove('hidden');
            return;
        }

        const fmt = (n) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(n);
        document.getElementById('result-per-kg').textContent = fmt(json.price_per_kg);
        document.getElementById('result-days').textContent = json.estimated_days + ' Hari';
        document.getElementById('result-total').textContent = fmt(json.total);
        resultEl.classList.remove('hidden');
    } catch (err) {
        document.getElementById('rate-error-msg').textContent = 'Terjadi kesalahan. Coba lagi.';
        errorEl.classList.remove('hidden');
    }
});
</script>
@endpush
@endsection
