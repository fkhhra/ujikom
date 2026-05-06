@extends('layouts.dashboard')
@section('title', 'Dashboard Kasir')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->guard('web')->user()?->name)

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pengiriman Hari Ini</p>
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">{{ $todayShipments }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Menunggu Bayar</p>
            <div class="w-9 h-9 bg-yellow-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">{{ $pendingPayments }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pendapatan Hari Ini</p>
            <div class="w-9 h-9 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
    </div>
</div>

{{-- Scan + Quick actions --}}
<div class="grid md:grid-cols-2 gap-5 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <h3 class="font-bold text-[#1a2d5a] mb-4">Scan Resi</h3>
        <form action="{{ route('cashier.shipments.scan') }}" method="POST" class="flex gap-2">
            @csrf
            <input type="text" name="tracking_number" placeholder="Masukkan nomor resi..." class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none uppercase" style="text-transform:uppercase">
            <button type="submit" class="bg-[#1a2d5a] hover:bg-[#162250] text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors">Cari</button>
        </form>
    </div>
    <div class="bg-[#6abf2e]/5 border border-[#6abf2e]/20 rounded-xl p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </div>
        <div class="flex-1">
            <p class="font-semibold text-[#1a2d5a] text-sm">Buat Pengiriman Baru</p>
            <p class="text-xs text-gray-500 mt-0.5">Input pengiriman dari pelanggan walk-in</p>
        </div>
        <a href="{{ route('cashier.shipments.create') }}" class="bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-4 py-2 rounded-lg text-sm transition-colors">Buat</a>
    </div>
</div>

{{-- Recent shipments --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="flex items-center justify-between p-5 border-b border-gray-50">
        <h3 class="font-bold text-[#1a2d5a]">Pengiriman Terbaru</h3>
        <a href="{{ route('cashier.shipments.index') }}" class="text-sm text-[#6abf2e] font-semibold hover:underline">Lihat semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">No. Resi</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Pengirim</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Pembayaran</th>
                <th class="px-5 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentShipments as $s)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3.5 font-mono text-xs font-semibold text-[#1a2d5a]">{{ $s->tracking_number }}</td>
                    <td class="px-5 py-3.5 text-gray-600 hidden sm:table-cell">{{ $s->sender?->name ?? '-' }}</td>
                    <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $s->status_badge }}">{{ $s->status_label }}</span></td>
                    <td class="px-5 py-3.5 hidden md:table-cell">
                        @if($s->payment)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $s->payment->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $s->payment->payment_status === 'paid' ? 'Lunas' : 'Belum' }}</span>
                        @else
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5"><a href="{{ route('cashier.shipments.show', $s) }}" class="text-[#6abf2e] text-xs font-semibold">Detail</a></td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-gray-400">Belum ada pengiriman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
