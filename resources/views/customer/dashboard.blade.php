@extends('layouts.dashboard')
@section('title', 'Dashboard - Trivo')

@section('sidebar')
@include('components.customer-sidebar')
@endsection

@section('main-content')
<div class="mb-6">
    <h1 class="text-2xl font-extrabold text-[#1a2b5c]">Dashboard</h1>
    <p class="text-gray-500 text-sm">Selamat datang, {{ Auth::guard('customer')->user()->name }}!</p>
</div>

{{-- STATS --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-[#1a2b5c]/10 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-[#1a2b5c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Total Dikirim</p>
                <p class="text-2xl font-extrabold text-[#1a2b5c]">{{ $totalSent }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-[#6abf2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Total Diterima</p>
                <p class="text-2xl font-extrabold text-[#1a2b5c]">{{ $totalReceived }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Sedang Dikirim</p>
                <p class="text-2xl font-extrabold text-[#1a2b5c]">{{ $activeShipments }}</p>
            </div>
        </div>
    </div>
</div>

{{-- TABS --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="border-b border-gray-100">
        <div class="flex">
            <a href="{{ route('customer.dashboard', ['tab' => 'outgoing']) }}"
                class="px-5 py-3.5 text-sm font-semibold border-b-2 transition-colors {{ $tab === 'outgoing' ? 'border-[#1a2b5c] text-[#1a2b5c]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Pengiriman Keluar
            </a>
            <a href="{{ route('customer.dashboard', ['tab' => 'incoming']) }}"
                class="px-5 py-3.5 text-sm font-semibold border-b-2 transition-colors {{ $tab === 'incoming' ? 'border-[#1a2b5c] text-[#1a2b5c]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Pengiriman Masuk
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        @if($shipments->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <p class="text-sm">Belum ada pengiriman</p>
        </div>
        @else
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-5 py-3 text-left">No. Resi</th>
                    <th class="px-5 py-3 text-left">{{ $tab === 'outgoing' ? 'Penerima' : 'Pengirim' }}</th>
                    <th class="px-5 py-3 text-left">Rute</th>
                    <th class="px-5 py-3 text-left">Status</th>
                    <th class="px-5 py-3 text-left">Biaya</th>
                    <th class="px-5 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                $statusMap = [
                    'pending' => ['Menunggu', 'bg-yellow-100 text-yellow-700'],
                    'picked_up' => ['Diambil', 'bg-blue-100 text-blue-700'],
                    'in_transit' => ['Dalam Perjalanan', 'bg-indigo-100 text-indigo-700'],
                    'arrived_at_branch' => ['Di Cabang', 'bg-purple-100 text-purple-700'],
                    'out_for_delivery' => ['Diantar', 'bg-orange-100 text-orange-700'],
                    'delivered' => ['Terkirim', 'bg-green-100 text-green-700'],
                    'cancelled' => ['Dibatalkan', 'bg-red-100 text-red-700'],
                ];
                @endphp
                @foreach($shipments as $shipment)
                @php $s = $statusMap[$shipment->status] ?? [$shipment->status, 'bg-gray-100 text-gray-700']; @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5 font-mono font-semibold text-[#1a2b5c] text-xs">{{ $shipment->tracking_number }}</td>
                    <td class="px-5 py-3.5 text-gray-700">{{ $tab === 'outgoing' ? $shipment->receiver?->name : $shipment->sender?->name }}</td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $shipment->originBranch?->city }} → {{ $shipment->destinationBranch?->city }}</td>
                    <td class="px-5 py-3.5"><span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $s[1] }}">{{ $s[0] }}</span></td>
                    <td class="px-5 py-3.5 text-gray-700">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5">
                        <a href="{{ route('customer.track', $shipment) }}" class="text-[#1a2b5c] hover:text-[#6abf2e] font-semibold text-xs transition-colors">Detail →</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    @if($shipments->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $shipments->links() }}
    </div>
    @endif
</div>
@endsection
