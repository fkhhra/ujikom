@extends('layouts.app')

@section('title', 'Detail Resi ' . $shipment->tracking_number . ' - Trivo')

@section('content')

<nav class="fixed w-full z-50 top-0 bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('images/branding/logo.png') }}" alt="Trivo" class="h-10">
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('tracking') }}" class="text-sm text-gray-600 hover:text-[#1a2b5c] transition-colors">← Lacak Lagi</a>
                <a href="{{ route('customer.login') }}" class="text-sm font-semibold bg-[#1a2b5c] text-white px-4 py-2 rounded-lg hover:bg-[#111e42] transition-all">Masuk</a>
            </div>
        </div>
    </div>
</nav>

<div class="min-h-screen bg-gray-50 pt-16">
    <div class="bg-[#1a2b5c] py-10">
        <div class="max-w-4xl mx-auto px-6">
            <p class="text-gray-400 text-sm mb-1">Nomor Resi</p>
            <h1 class="text-2xl font-extrabold text-white tracking-widest">{{ $shipment->tracking_number }}</h1>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 py-8 space-y-5">

        {{-- STATUS BADGE --}}
        @php
        $statusMap = [
            'pending'           => ['label' => 'Menunggu', 'color' => 'bg-yellow-100 text-yellow-700 border-yellow-200'],
            'picked_up'         => ['label' => 'Diambil Kurir', 'color' => 'bg-blue-100 text-blue-700 border-blue-200'],
            'in_transit'        => ['label' => 'Dalam Perjalanan', 'color' => 'bg-indigo-100 text-indigo-700 border-indigo-200'],
            'arrived_at_branch' => ['label' => 'Tiba di Cabang', 'color' => 'bg-purple-100 text-purple-700 border-purple-200'],
            'out_for_delivery'  => ['label' => 'Sedang Diantar', 'color' => 'bg-orange-100 text-orange-700 border-orange-200'],
            'delivered'         => ['label' => 'Terkirim', 'color' => 'bg-green-100 text-green-700 border-green-200'],
            'cancelled'         => ['label' => 'Dibatalkan', 'color' => 'bg-red-100 text-red-700 border-red-200'],
        ];
        $s = $statusMap[$shipment->status] ?? ['label' => $shipment->status, 'color' => 'bg-gray-100 text-gray-700 border-gray-200'];
        @endphp

        <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
            <div class="flex flex-wrap items-center gap-4 justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Status Pengiriman</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold border {{ $s['color'] }}">{{ $s['label'] }}</span>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 mb-1">Tanggal Pengiriman</p>
                    <p class="font-semibold text-[#1a2b5c] text-sm">{{ $shipment->shipment_date ? \Carbon\Carbon::parse($shipment->shipment_date)->isoFormat('D MMMM Y') : '-' }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- PENGIRIM --}}
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                <h3 class="font-bold text-[#1a2b5c] text-sm mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#6abf2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Pengirim
                </h3>
                <p class="font-semibold text-gray-800">{{ $shipment->sender?->name ?? '-' }}</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ $shipment->sender?->phone ?? '' }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $shipment->originBranch?->name }} — {{ $shipment->originBranch?->city }}</p>
            </div>

            {{-- PENERIMA --}}
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                <h3 class="font-bold text-[#1a2b5c] text-sm mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#6abf2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    Penerima
                </h3>
                <p class="font-semibold text-gray-800">{{ $shipment->receiver?->name ?? '-' }}</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ $shipment->receiver?->phone ?? '' }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $shipment->destinationBranch?->name }} — {{ $shipment->destinationBranch?->city }}</p>
            </div>
        </div>

        {{-- DETAIL PAKET --}}
        <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-4">Detail Paket</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-500 mb-1">Total Berat</p>
                    <p class="font-bold text-[#1a2b5c]">{{ $shipment->total_weight }} kg</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-500 mb-1">Total Biaya</p>
                    <p class="font-bold text-[#6abf2e]">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-500 mb-1">Pembayar</p>
                    <p class="font-bold text-[#1a2b5c] capitalize">{{ $shipment->payer_type }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-500 mb-1">Status Bayar</p>
                    <p class="font-bold text-[#1a2b5c]">{{ $shipment->payment?->payment_status ? ucfirst($shipment->payment->payment_status) : 'Belum Bayar' }}</p>
                </div>
            </div>
        </div>

        {{-- TIMELINE --}}
        @if($shipment->trackings->count())
        <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-5">Riwayat Perjalanan</h3>
            <ol class="relative border-s border-[#6abf2e]/30 ms-3">
                @foreach($shipment->trackings->sortByDesc('tracked_at') as $track)
                <li class="mb-6 ms-6">
                    <span class="absolute flex items-center justify-center w-7 h-7 bg-[#6abf2e] rounded-full -start-3.5 ring-4 ring-white">
                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </span>
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex items-center justify-between flex-wrap gap-2 mb-1">
                            <span class="text-sm font-semibold text-[#1a2b5c]">{{ $track->location }}</span>
                            <time class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($track->tracked_at)->isoFormat('D MMM Y, HH:mm') }}</time>
                        </div>
                        <p class="text-xs text-gray-600">{{ $track->description }}</p>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
        @endif
    </div>
</div>
@endsection
