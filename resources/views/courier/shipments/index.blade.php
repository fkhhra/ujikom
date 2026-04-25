@extends('layouts.dashboard')
@section('title', 'Tugas Pengiriman - Kurir Trivo')
@section('sidebar')
@include('components.courier-sidebar')
@endsection
@section('main-content')
<div class="mb-6">
    <h1 class="text-2xl font-extrabold text-[#1a2b5c]">Tugas Pengiriman</h1>
    <p class="text-gray-500 text-sm">Daftar paket yang perlu Anda antar</p>
</div>

{{-- STATS --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    @php
    $statuses = ['pending'=>['Menunggu','bg-yellow-50 border-yellow-100','text-yellow-600'],'picked_up'=>['Diambil','bg-blue-50 border-blue-100','text-blue-600'],'out_for_delivery'=>['Diantar','bg-orange-50 border-orange-100','text-orange-600'],'delivered'=>['Terkirim','bg-green-50 border-green-100','text-green-600']];
    @endphp
    @foreach($statuses as $status => [$label, $bg, $textColor])
    <div class="rounded-2xl p-4 border {{ $bg }} text-center">
        <p class="text-2xl font-extrabold {{ $textColor }}">{{ $shipments->where('status', $status)->count() }}</p>
        <p class="text-xs font-semibold {{ $textColor }} mt-1">{{ $label }}</p>
    </div>
    @endforeach
</div>

<div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                <option value="">Semua</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Menunggu</option>
                <option value="picked_up" {{ request('status')=='picked_up'?'selected':'' }}>Sudah Diambil</option>
                <option value="out_for_delivery" {{ request('status')=='out_for_delivery'?'selected':'' }}>Sedang Diantar</option>
                <option value="delivered" {{ request('status')=='delivered'?'selected':'' }}>Terkirim</option>
            </select>
        </div>
        <button type="submit" class="bg-[#1a2b5c] hover:bg-[#111e42] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all">Filter</button>
    </form>
</div>

<div class="space-y-3">
    @forelse($shipments as $shipment)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:border-[#1a2b5c]/20 transition-all">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 mb-2">
                    <span class="font-mono font-bold text-[#1a2b5c] text-sm">{{ $shipment->tracking_number }}</span>
                    <x-status-badge :status="$shipment->status"/>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                    <div>
                        <p class="text-xs text-gray-400">Dari</p>
                        <p class="font-semibold text-gray-700">{{ $shipment->sender?->name }}</p>
                        <p class="text-xs text-gray-500">{{ $shipment->originBranch?->city }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Ke</p>
                        <p class="font-semibold text-gray-700">{{ $shipment->receiver?->name }}</p>
                        <p class="text-xs text-gray-500">{{ $shipment->destinationBranch?->city }}</p>
                    </div>
                </div>
                <div class="mt-2 text-xs text-gray-500">
                    Berat: <span class="font-semibold">{{ $shipment->total_weight }} kg</span>
                    @if($shipment->shipment_date)
                    · Tanggal: <span class="font-semibold">{{ \Carbon\Carbon::parse($shipment->shipment_date)->format('d/m/Y') }}</span>
                    @endif
                </div>
            </div>
            <div class="flex flex-col gap-2 items-end">
                <a href="{{ route('courier.shipments.show', $shipment) }}"
                    class="bg-[#1a2b5c] hover:bg-[#111e42] text-white font-semibold px-4 py-2 rounded-lg text-xs transition-all">
                    Detail & Update
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center text-gray-400">
        <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <p class="text-sm">Tidak ada tugas pengiriman</p>
    </div>
    @endforelse
</div>

@if($shipments instanceof \Illuminate\Pagination\LengthAwarePaginator && $shipments->hasPages())
<div class="mt-4">{{ $shipments->links() }}</div>
@endif
@endsection
