@extends('layouts.dashboard')
@section('title', 'Dashboard Kurir')
@section('page-title', 'Dashboard Kurir')
@section('page-subtitle', 'Selamat datang, ' . auth()->guard('web')->user()?->name)

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Aktif Sekarang</p>
            <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">{{ $activeShipments->count() }}</p>
        <p class="text-xs text-gray-400 mt-1">Pengiriman berjalan</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Selesai Hari Ini</p>
            <div class="w-9 h-9 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">{{ $todayDelivered }}</p>
        <p class="text-xs text-gray-400 mt-1">Terkirim hari ini</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Terkirim</p>
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">{{ $totalDelivered }}</p>
        <p class="text-xs text-gray-400 mt-1">Sepanjang waktu</p>
    </div>
</div>

{{-- Active shipments --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="flex items-center justify-between p-5 border-b border-gray-50">
        <h3 class="font-bold text-[#1a2d5a]">Pengiriman Aktif</h3>
        <a href="{{ route('courier.shipments.index') }}" class="text-sm text-[#6abf2e] font-semibold hover:underline">Semua →</a>
    </div>
    <div class="divide-y divide-gray-50">
        @forelse($activeShipments as $s)
        <a href="{{ route('courier.shipments.show', $s) }}" class="flex items-center gap-4 p-4 hover:bg-gray-50/50 transition-colors">
            <div class="w-10 h-10 bg-[#1a2d5a]/5 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-[#1a2d5a]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-mono text-xs font-semibold text-[#1a2d5a]">{{ $s->tracking_number }}</p>
                <p class="text-sm text-gray-600 truncate">{{ $s->receiver?->name }} · {{ $s->destinationBranch?->city }}</p>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $s->status_badge }} flex-shrink-0">{{ $s->status_label }}</span>
        </a>
        @empty
        <div class="p-8 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <p class="text-sm">Tidak ada pengiriman aktif saat ini</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
