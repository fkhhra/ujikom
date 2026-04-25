@extends('layouts.dashboard')
@section('title', 'Lacak Paket - Trivo')

@section('sidebar')
@include('components.customer-sidebar')
@endsection

@section('main-content')
<div class="mb-5">
    <a href="{{ route('customer.dashboard') }}" class="text-sm text-gray-500 hover:text-[#1a2b5c] transition-colors">← Kembali</a>
    <h1 class="text-2xl font-extrabold text-[#1a2b5c] mt-1">Detail Pengiriman</h1>
    <p class="text-gray-500 text-sm font-mono">{{ $shipment->tracking_number }}</p>
</div>

@php
$statusMap = [
    'pending' => ['Menunggu', 'bg-yellow-100 text-yellow-700 border-yellow-200'],
    'picked_up' => ['Diambil Kurir', 'bg-blue-100 text-blue-700 border-blue-200'],
    'in_transit' => ['Dalam Perjalanan', 'bg-indigo-100 text-indigo-700 border-indigo-200'],
    'arrived_at_branch' => ['Tiba di Cabang', 'bg-purple-100 text-purple-700 border-purple-200'],
    'out_for_delivery' => ['Sedang Diantar', 'bg-orange-100 text-orange-700 border-orange-200'],
    'delivered' => ['Terkirim', 'bg-green-100 text-green-700 border-green-200'],
    'cancelled' => ['Dibatalkan', 'bg-red-100 text-red-700 border-red-200'],
];
$s = $statusMap[$shipment->status] ?? [$shipment->status, 'bg-gray-100 text-gray-700 border-gray-200'];
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2 space-y-5">
        {{-- STATUS --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex flex-wrap items-center gap-4 justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Status</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold border {{ $s[1] }}">{{ $s[0] }}</span>
                </div>
                @if($shipment->payment && $shipment->payment->payment_status === 'pending')
                <a href="{{ route('customer.payments.checkout', $shipment->payment) }}" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-4 py-2 rounded-lg text-sm transition-all">
                    Bayar Sekarang
                </a>
                @endif
            </div>
        </div>

        {{-- PENGIRIM & PENERIMA --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-[#1a2b5c] text-sm mb-3">Pengirim</h3>
                <p class="font-semibold text-gray-800">{{ $shipment->sender?->name }}</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ $shipment->sender?->phone }}</p>
                <p class="text-xs text-gray-400 mt-2">{{ $shipment->originBranch?->name }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-[#1a2b5c] text-sm mb-3">Penerima</h3>
                <p class="font-semibold text-gray-800">{{ $shipment->receiver?->name }}</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ $shipment->receiver?->phone }}</p>
                <p class="text-xs text-gray-400 mt-2">{{ $shipment->destinationBranch?->name }}</p>
            </div>
        </div>

        {{-- TIMELINE --}}
        @if($shipment->trackings->count())
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-5">Riwayat Perjalanan</h3>
            <ol class="relative border-s border-[#6abf2e]/30 ms-3">
                @foreach($shipment->trackings->sortByDesc('tracked_at') as $track)
                <li class="mb-5 ms-6">
                    <span class="absolute flex items-center justify-center w-7 h-7 bg-[#6abf2e] rounded-full -start-3.5 ring-4 ring-white">
                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </span>
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                            <span class="text-sm font-semibold text-[#1a2b5c]">{{ $track->location }}</span>
                            <time class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($track->tracked_at)->isoFormat('D MMM, HH:mm') }}</time>
                        </div>
                        <p class="text-xs text-gray-600">{{ $track->description }}</p>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
        @endif
    </div>

    {{-- SIDEBAR INFO --}}
    <div class="space-y-4">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-4">Ringkasan</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Berat</span>
                    <span class="font-semibold">{{ $shipment->total_weight }} kg</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Total Biaya</span>
                    <span class="font-bold text-[#6abf2e]">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Pembayar</span>
                    <span class="font-semibold capitalize">{{ $shipment->payer_type }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status Bayar</span>
                    @php
                    $payStatus = $shipment->payment?->payment_status ?? 'unpaid';
                    $payColor = $payStatus === 'paid' ? 'text-green-600' : ($payStatus === 'pending' ? 'text-orange-500' : 'text-red-500');
                    @endphp
                    <span class="font-semibold {{ $payColor }}">{{ ucfirst($payStatus) }}</span>
                </div>
                @if($shipment->shipment_date)
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Kirim</span>
                    <span class="font-semibold">{{ \Carbon\Carbon::parse($shipment->shipment_date)->isoFormat('D MMM Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        @if($shipment->items->count())
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-4">Item Paket</h3>
            <div class="space-y-2">
                @foreach($shipment->items as $item)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-700">{{ $item->name }}</span>
                    <span class="text-gray-500">{{ $item->weight }} kg</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
