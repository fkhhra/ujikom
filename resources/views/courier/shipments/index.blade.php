@extends('layouts.dashboard')
@section('title', 'Pengiriman Saya')
@section('page-title', 'Pengiriman Saya')

@section('content')
{{-- Mini stats --}}
<div class="grid grid-cols-2 gap-4 mb-5">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-[#1a2d5a]">{{ $activeCount }}</p>
            <p class="text-xs text-gray-500">Sedang Berjalan</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-[#1a2d5a]">{{ $deliveredCount }}</p>
            <p class="text-xs text-gray-500">Total Terkirim</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="p-4 border-b border-gray-50">
        <form method="GET" class="flex flex-wrap gap-3">
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                <option value="">Semua Status</option>
                @foreach(['pending'=>'Menunggu','picked_up'=>'Dijemput','in_transit'=>'Dalam Perjalanan','arrived_at_branch'=>'Tiba di Cabang','out_for_delivery'=>'Sedang Diantar','delivered'=>'Terkirim'] as $v => $l)
                    <option value="{{ $v }}" {{ request('status')===$v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-[#1a2d5a] text-white text-sm font-semibold px-5 py-2 rounded-lg">Filter</button>
            @if(request('status'))<a href="{{ route('courier.shipments.index') }}" class="px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-500 hover:bg-gray-50">Reset</a>@endif
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">No. Resi</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Penerima</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Tujuan</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="px-5 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($shipments as $s)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3.5 font-mono text-xs font-semibold text-[#1a2d5a]">{{ $s->tracking_number }}</td>
                    <td class="px-5 py-3.5 text-gray-600 hidden sm:table-cell">{{ $s->receiver?->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs hidden md:table-cell">{{ $s->destinationBranch?->city ?? '-' }}</td>
                    <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $s->status_badge }}">{{ $s->status_label }}</span></td>
                    <td class="px-5 py-3.5"><a href="{{ route('courier.shipments.show', $s) }}" class="text-[#6abf2e] text-xs font-semibold hover:underline">Detail</a></td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">Tidak ada data pengiriman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($shipments->hasPages())<div class="p-4 border-t border-gray-50">{{ $shipments->links() }}</div>@endif
</div>
@endsection
