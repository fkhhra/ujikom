@extends('layouts.app')

@section('title', 'Trivo - Jasa Pengiriman Cepat & Terpercaya')

@push('styles')
<style>
.hero-carousel { position: relative; overflow: hidden; border-radius: 1rem; }
.carousel-item { display: none; position: relative; }
.carousel-item.active { display: block; }
.carousel-item img { width: 100%; height: 480px; object-fit: cover; }
.carousel-overlay { position: absolute; inset: 0; background: linear-gradient(to right, rgba(26,45,90,0.85) 40%, rgba(26,45,90,0.2)); }
.stat-card { background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-align: center; transition: transform 0.2s; }
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.feature-card { background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #f1f5f9; transition: all 0.2s; }
.feature-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.1); transform: translateY(-2px); }
.section-badge { display: inline-flex; align-items: center; gap: 0.375rem; background: #f0fdf4; color: #6abf2e; font-size: 0.75rem; font-weight: 600; padding: 0.25rem 0.75rem; border-radius: 9999px; border: 1px solid #bbf7d0; margin-bottom: 0.75rem; }
</style>
@endpush

@section('content')

{{-- Hero Carousel --}}
<section class="relative bg-[#1a2d5a]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid lg:grid-cols-2 gap-8 items-center">
            {{-- Text --}}
            <div class="text-white z-10 py-6 lg:py-12">
                <div class="inline-flex items-center gap-2 bg-[#6abf2e]/20 border border-[#6abf2e]/40 text-[#6abf2e] text-xs font-semibold px-3 py-1.5 rounded-full mb-5">
                    <span class="w-1.5 h-1.5 bg-[#6abf2e] rounded-full animate-pulse"></span>
                    Pengiriman ke Seluruh Indonesia
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight mb-5">
                    Kirim Paket<br>
                    <span class="text-[#6abf2e]">Cepat & Aman</span><br>
                    Sampai Tujuan
                </h1>
                <p class="text-gray-300 text-base sm:text-lg max-w-md leading-relaxed mb-8">
                    Layanan pengiriman ekspres dengan jangkauan luas, harga terjangkau, dan tracking real-time untuk memastikan paket Anda tiba tepat waktu.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('tracking') }}" class="inline-flex items-center gap-2 bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Lacak Paket
                    </a>
                    <a href="{{ route('customer.register') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/30 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                        Daftar Sekarang
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                {{-- Stats row --}}
                <div class="flex gap-6 mt-10 pt-8 border-t border-white/10">
                    <div>
                        <p class="text-2xl font-extrabold text-white">50+</p>
                        <p class="text-xs text-gray-400 mt-0.5">Kota Tujuan</p>
                    </div>
                    <div class="w-px bg-white/10"></div>
                    <div>
                        <p class="text-2xl font-extrabold text-white">10K+</p>
                        <p class="text-xs text-gray-400 mt-0.5">Paket Terkirim</p>
                    </div>
                    <div class="w-px bg-white/10"></div>
                    <div>
                        <p class="text-2xl font-extrabold text-white">{{ $branches->count() }}+</p>
                        <p class="text-xs text-gray-400 mt-0.5">Cabang Aktif</p>
                    </div>
                </div>
            </div>

            {{-- Carousel --}}
            <div class="relative hidden lg:block">
                <div id="hero-carousel" class="rounded-2xl overflow-hidden shadow-2xl">
                    <div class="carousel-slide active">
                        <img src="{{ asset('images/carousel/carousel-1.webp') }}" alt="Layanan Pengiriman" class="w-full h-80 object-cover">
                    </div>
                    <div class="carousel-slide hidden">
                        <img src="{{ asset('images/carousel/carousel-2.webp') }}" alt="Tim Profesional" class="w-full h-80 object-cover">
                    </div>
                    <div class="carousel-slide hidden">
                        <img src="{{ asset('images/carousel/carousel-3.webp') }}" alt="Pengemasan Aman" class="w-full h-80 object-cover">
                    </div>
                </div>
                {{-- Dots --}}
                <div class="flex justify-center gap-2 mt-4">
                    <button onclick="goSlide(0)" class="carousel-dot w-2.5 h-2.5 rounded-full bg-[#6abf2e] transition-all"></button>
                    <button onclick="goSlide(1)" class="carousel-dot w-2.5 h-2.5 rounded-full bg-white/30 transition-all"></button>
                    <button onclick="goSlide(2)" class="carousel-dot w-2.5 h-2.5 rounded-full bg-white/30 transition-all"></button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Quick tracking bar --}}
<section class="bg-white shadow-md py-4 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('track') }}" method="POST" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
            @csrf
            <div class="flex-1 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="tracking_number" placeholder="Masukkan nomor resi (contoh: KA...)" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none">
            </div>
            <button type="submit" class="bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors whitespace-nowrap">
                Lacak Sekarang
            </button>
        </form>
    </div>
</section>

{{-- Features --}}
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
        <span class="section-badge">Mengapa Trivo?</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1a2d5a]">Layanan Terbaik untuk Anda</h2>
        <p class="text-gray-500 mt-2 max-w-xl mx-auto text-sm">Kami berkomitmen memberikan pengalaman pengiriman yang nyaman, aman, dan tepat waktu.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="feature-card">
            <div class="w-12 h-12 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <h3 class="font-bold text-[#1a2d5a] mb-2">Pengiriman Cepat</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Estimasi pengiriman 1–5 hari kerja ke seluruh kota tujuan dengan armada yang handal.</p>
        </div>
        <div class="feature-card">
            <div class="w-12 h-12 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <h3 class="font-bold text-[#1a2d5a] mb-2">Paket Aman</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Setiap paket ditangani secara profesional dengan pengemasan standar untuk menjaga keamanan barang.</p>
        </div>
        <div class="feature-card">
            <div class="w-12 h-12 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h3 class="font-bold text-[#1a2d5a] mb-2">Tracking Real-time</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Pantau posisi paket Anda setiap saat menggunakan nomor resi langsung dari halaman pelacakan kami.</p>
        </div>
        <div class="feature-card">
            <div class="w-12 h-12 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <h3 class="font-bold text-[#1a2d5a] mb-2">Bayar Mudah</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Berbagai metode pembayaran tersedia — transfer bank, QRIS, e-wallet, hingga bayar di tempat (COD).</p>
        </div>
    </div>
</section>

{{-- Cek Tarif --}}
<section id="cek-tarif" class="bg-[#1a2d5a] py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-white">
                <span class="inline-flex items-center gap-1.5 bg-[#6abf2e]/20 border border-[#6abf2e]/40 text-[#6abf2e] text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                    Kalkulator Tarif
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold mb-4">Cek Tarif Pengiriman</h2>
                <p class="text-gray-300 text-sm leading-relaxed mb-6">Hitung estimasi biaya pengiriman dari kota asal ke tujuan Anda dengan mudah dan cepat.</p>
                <div class="bg-white/5 border border-white/10 rounded-xl p-4 space-y-3">
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <svg class="w-4 h-4 text-[#6abf2e]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Tarif transparan, tanpa biaya tersembunyi
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <svg class="w-4 h-4 text-[#6abf2e]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Harga per kg yang kompetitif
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <svg class="w-4 h-4 text-[#6abf2e]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Estimasi waktu pengiriman akurat
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-xl">
                <h3 class="font-bold text-[#1a2d5a] text-lg mb-5">Form Cek Tarif</h3>
                <div class="space-y-4" id="rate-form">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kota Asal</label>
                        <select id="origin_city" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none bg-white">
                            <option value="">Pilih kota asal</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kota Tujuan</label>
                        <select id="destination_city" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none bg-white">
                            <option value="">Pilih kota tujuan</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Berat (kg)</label>
                        <input type="number" id="weight" min="0.1" step="0.1" placeholder="Contoh: 2.5" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none">
                    </div>
                    <button onclick="checkRate()" class="w-full bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">
                        Hitung Tarif
                    </button>
                </div>

                {{-- Result --}}
                <div id="rate-result" class="hidden mt-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                    <p class="text-xs font-semibold text-green-700 uppercase tracking-wide mb-3">Hasil Kalkulasi</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-white rounded-lg p-3 border border-green-100">
                            <p class="text-xs text-gray-500">Harga/kg</p>
                            <p id="result-price" class="font-bold text-[#1a2d5a] text-base mt-0.5">-</p>
                        </div>
                        <div class="bg-white rounded-lg p-3 border border-green-100">
                            <p class="text-xs text-gray-500">Estimasi Tiba</p>
                            <p id="result-days" class="font-bold text-[#1a2d5a] text-base mt-0.5">-</p>
                        </div>
                        <div class="bg-white rounded-lg p-3 border border-green-100 col-span-2">
                            <p class="text-xs text-gray-500">Total Ongkos Kirim</p>
                            <p id="result-total" class="font-bold text-[#6abf2e] text-xl mt-0.5">-</p>
                        </div>
                    </div>
                </div>
                <div id="rate-error" class="hidden mt-4 p-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg"></div>
            </div>
        </div>
    </div>
</section>

{{-- Cabang --}}
@if($branches->count() > 0)
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
        <span class="section-badge">Jaringan Kami</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1a2d5a]">Cabang Trivo</h2>
        <p class="text-gray-500 mt-2 text-sm">Temukan cabang terdekat kami di kota Anda.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($branches as $branch)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex gap-4 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
            </div>
            <div class="min-w-0">
                <h4 class="font-semibold text-[#1a2d5a] text-sm">{{ $branch->name }}</h4>
                <p class="text-gray-500 text-xs mt-1 leading-relaxed truncate">{{ $branch->address }}</p>
                @if($branch->phone)
                    <p class="text-[#6abf2e] text-xs mt-1 font-medium">{{ $branch->phone }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-16 bg-gradient-to-br from-[#6abf2e] to-[#4a9020]">
    <div class="max-w-3xl mx-auto text-center px-4">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-4">Siap Mulai Mengirim?</h2>
        <p class="text-white/80 mb-8 text-sm">Daftar sekarang dan nikmati kemudahan layanan pengiriman Trivo untuk kebutuhan personal maupun bisnis Anda.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('customer.register') }}" class="inline-flex items-center gap-2 bg-white text-[#6abf2e] font-bold px-8 py-3 rounded-xl hover:bg-gray-50 transition-colors shadow-lg">
                Daftar Gratis
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="{{ route('tracking') }}" class="inline-flex items-center gap-2 bg-transparent border-2 border-white text-white font-bold px-8 py-3 rounded-xl hover:bg-white/10 transition-colors">
                Lacak Paket
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Carousel
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.carousel-dot');

function goSlide(n) {
    slides[currentSlide].classList.add('hidden');
    slides[currentSlide].classList.remove('active');
    dots[currentSlide].classList.remove('bg-[#6abf2e]');
    dots[currentSlide].classList.add('bg-white/30');
    currentSlide = n;
    slides[currentSlide].classList.remove('hidden');
    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('bg-[#6abf2e]');
    dots[currentSlide].classList.remove('bg-white/30');
}

setInterval(() => { goSlide((currentSlide + 1) % slides.length); }, 5000);

// Rate checker
function checkRate() {
    const origin = document.getElementById('origin_city').value;
    const destination = document.getElementById('destination_city').value;
    const weight = document.getElementById('weight').value;
    const result = document.getElementById('rate-result');
    const error = document.getElementById('rate-error');

    result.classList.add('hidden');
    error.classList.add('hidden');

    if (!origin || !destination || !weight) {
        error.textContent = 'Mohon lengkapi semua field.';
        error.classList.remove('hidden');
        return;
    }

    fetch('{{ route("check-rate") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: JSON.stringify({ origin_city: origin, destination_city: destination, weight: parseFloat(weight) })
    })
    .then(r => r.json())
    .then(data => {
        if (data.error) {
            error.textContent = data.error;
            error.classList.remove('hidden');
        } else {
            document.getElementById('result-price').textContent = 'Rp ' + Number(data.price_per_kg).toLocaleString('id-ID');
            document.getElementById('result-days').textContent = data.estimated_days + ' hari kerja';
            document.getElementById('result-total').textContent = 'Rp ' + Number(data.total).toLocaleString('id-ID');
            result.classList.remove('hidden');
        }
    })
    .catch(() => {
        error.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
        error.classList.remove('hidden');
    });
}
</script>
@endpush
