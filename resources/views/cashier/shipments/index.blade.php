@extends('layouts.dashboard')
@section('title', 'Pengiriman')
@section('page-title', 'Pengiriman Cabang')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('cashier.shipments.create') }}" class="inline-flex items-center gap-2 bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Buat Pengiriman
    </a>
</div>
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="p-4 border-b border-gray-50">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-48 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor resi..." class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
            </div>
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                <option value="">Semua Status</option>
                @foreach(['pending'=>'Menunggu','picked_up'=>'Dijemput','in_transit'=>'Dalam Perjalanan','arrived_at_branch'=>'Tiba di Cabang','out_for_delivery'=>'Sedang Diantar','delivered'=>'Terkirim','cancelled'=>'Dibatalkan'] as $v => $l)
                    <option value="{{ $v }}" {{ request('status')===$v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-[#1a2d5a] text-white text-sm font-semibold px-5 py-2 rounded-lg">Filter</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">No. Resi</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Pengirim</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Tujuan</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Bayar</th>
                <th class="px-5 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($shipments as $s)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3.5 font-mono text-xs font-semibold text-[#1a2d5a]">{{ $s->tracking_number }}</td>
                    <td class="px-5 py-3.5 text-gray-600 hidden sm:table-cell">{{ $s->sender?->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs hidden md:table-cell">{{ $s->destinationBranch?->city ?? '-' }}</td>
                    <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $s->status_badge }}">{{ $s->status_label }}</span></td>
                    <td class="px-5 py-3.5 hidden lg:table-cell">
                        @if($s->payment)<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $s->payment->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $s->payment->payment_status === 'paid' ? 'Lunas' : 'Belum' }}</span>
                        @else<span class="text-gray-400 text-xs">—</span>@endif
                    </td>
                    <td class="px-5 py-3.5"><a href="{{ route('cashier.shipments.show', $s) }}" class="text-[#6abf2e] text-xs font-semibold">Detail</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400">Tidak ada pengiriman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($shipments->hasPages())<div class="p-4 border-t border-gray-50">{{ $shipments->links() }}</div>@endif
</div>
@endsection
