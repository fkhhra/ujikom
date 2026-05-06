@extends('layouts.app')
@section('title', 'Resi ' . $shipment->tracking_number . ' - Trivo')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('tracking') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1a2d5a] transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Lacak Paket
        </a>
    </div>

    {{-- Header card --}}
    <div class="bg-[#1a2d5a] rounded-2xl p-6 text-white mb-6 shadow-lg">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold mb-1">Nomor Resi</p>
                <p class="text-2xl font-extrabold tracking-wider">{{ $shipment->tracking_number }}</p>
                <p class="text-sm text-gray-400 mt-1">{{ $shipment->shipment_date?->format('d M Y') }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $shipment->status_badge }}">
                {{ $shipment->status_label }}
            </span>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-5 pt-5 border-t border-white/10">
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Asal</p>
                <p class="font-semibold text-sm">{{ $shipment->originBranch?->city ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Tujuan</p>
                <p class="font-semibold text-sm">{{ $shipment->destinationBranch?->city ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Pengirim</p>
                <p class="font-semibold text-sm">{{ $shipment->sender?->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Penerima</p>
                <p class="font-semibold text-sm">{{ $shipment->receiver?->name ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Tracking timeline --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="font-bold text-[#1a2d5a] mb-6">Riwayat Pengiriman</h3>

        @if($shipment->trackings->isEmpty())
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="text-gray-400 text-sm">Belum ada riwayat pengiriman</p>
            </div>
        @else
            <ol class="relative border-l-2 border-gray-100 ml-3">
                @foreach($shipment->trackings->reverse() as $i => $tracking)
                <li class="mb-6 ml-6 last:mb-0">
                    <span class="absolute flex items-center justify-center w-6 h-6 rounded-full -left-3.5 {{ $i === 0 ? 'bg-[#6abf2e]' : 'bg-gray-200' }}">
                        @if($i === 0)
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @else
                            <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                        @endif
                    </span>
                    <div class="{{ $i === 0 ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-100' }} rounded-xl p-4">
                        <div class="flex flex-wrap items-start justify-between gap-2 mb-1">
                            <span class="font-semibold text-sm text-[#1a2d5a]">{{ $tracking->status_label }}</span>
                            <time class="text-xs text-gray-400">{{ $tracking->tracked_at?->format('d M Y, H:i') }}</time>
                        </div>
                        <p class="text-sm text-gray-600">{{ $tracking->description }}</p>
                        @if($tracking->location)
                            <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $tracking->location }}
                            </p>
                        @endif
                    </div>
                </li>
                @endforeach
            </ol>
        @endif
    </div>

    {{-- Shipment details --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-[#1a2d5a] mb-5">Detail Pengiriman</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400 text-xs mb-0.5">Total Berat</p>
                <p class="font-semibold text-gray-700">{{ number_format($shipment->total_weight, 1) }} kg</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-0.5">Total Harga</p>
                <p class="font-semibold text-gray-700">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-0.5">Pembayaran</p>
                <p class="font-semibold text-gray-700">{{ $shipment->isCod() ? 'COD (Bayar di Tempat)' : 'Dibayar Pengirim' }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-0.5">Status Pembayaran</p>
                @if($shipment->payment)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $shipment->payment->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $shipment->payment->payment_status === 'paid' ? 'Lunas' : 'Menunggu' }}
                    </span>
                @else
                    <span class="text-gray-400 text-xs">—</span>
                @endif
            </div>
        </div>

        @if($shipment->items->isNotEmpty())
            <div class="mt-5 pt-5 border-t border-gray-100">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Item Paket</p>
                <div class="space-y-2">
                    @foreach($shipment->items as $item)
                    <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ $item->name }}</p>
                            <p class="text-xs text-gray-400">{{ $item->quantity }}x · {{ number_format($item->weight, 2) }} kg</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
