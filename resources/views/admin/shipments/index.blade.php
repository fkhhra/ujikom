@extends('layouts.dashboard')
@section('title', 'Pengiriman')
@section('page-title', 'Manajemen Pengiriman')
@section('page-subtitle', 'Daftar semua pengiriman')

@section('content')
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    {{-- Filters --}}
    <div class="p-4 sm:p-5 border-b border-gray-50">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor resi..." class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none">
            </div>
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none bg-white">
                <option value="">Semua Status</option>
                @foreach(['pending'=>'Menunggu','picked_up'=>'Dijemput','in_transit'=>'Dalam Perjalanan','arrived_at_branch'=>'Tiba di Cabang','out_for_delivery'=>'Sedang Diantar','delivered'=>'Terkirim','cancelled'=>'Dibatalkan'] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-[#1a2d5a] hover:bg-[#162250] text-white text-sm font-semibold px-5 py-2 rounded-lg transition-colors">Filter</button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.shipments.index') }}" class="text-sm text-gray-500 hover:text-gray-700 px-3 py-2 rounded-lg border border-gray-200 transition-colors">Reset</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">No. Resi</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Pengirim</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Rute</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Total</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Tanggal</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($shipments as $s)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3.5 font-mono text-xs font-semibold text-[#1a2d5a]">{{ $s->tracking_number }}</td>
                    <td class="px-5 py-3.5 text-gray-600 hidden sm:table-cell">{{ $s->sender?->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs hidden md:table-cell">{{ $s->originBranch?->city }} → {{ $s->destinationBranch?->city }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $s->status_badge }}">{{ $s->status_label }}</span>
                    </td>
                    <td class="px-5 py-3.5 font-semibold text-gray-700 hidden lg:table-cell">Rp {{ number_format($s->total_price, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5 text-gray-400 text-xs hidden lg:table-cell">{{ $s->shipment_date?->format('d M Y') }}</td>
                    <td class="px-5 py-3.5">
                        <a href="{{ route('admin.shipments.show', $s) }}" class="text-[#6abf2e] hover:text-[#5aaa25] font-semibold text-xs">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-gray-400">Tidak ada data pengiriman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($shipments->hasPages())
        <div class="p-4 border-t border-gray-50">{{ $shipments->links() }}</div>
    @endif
</div>
@endsection
