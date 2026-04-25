@extends('layouts.dashboard')
@section('title', 'Pengiriman - Trivo Admin')

@section('sidebar')
@include('components.admin-sidebar')
@endsection

@section('main-content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-[#1a2b5c]">Pengiriman</h1>
        <p class="text-gray-500 text-sm">Kelola semua data pengiriman</p>
    </div>
</div>

{{-- FILTER --}}
<div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Cari Resi</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nomor resi..."
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
        </div>
        <div class="min-w-40">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                <option value="">Semua Status</option>
                @foreach(['pending'=>'Menunggu','picked_up'=>'Diambil','in_transit'=>'Transit','arrived_at_branch'=>'Di Cabang','out_for_delivery'=>'Diantar','delivered'=>'Terkirim','cancelled'=>'Dibatalkan'] as $val => $label)
                <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-[#1a2b5c] hover:bg-[#111e42] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all">Filter</button>
        @if(request()->anyFilled(['search','status']))
        <a href="{{ route('admin.shipments.index') }}" class="text-sm text-gray-500 hover:text-red-500 transition-colors py-2">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-5 py-3 text-left">Resi</th>
                    <th class="px-5 py-3 text-left">Pengirim</th>
                    <th class="px-5 py-3 text-left">Penerima</th>
                    <th class="px-5 py-3 text-left">Rute</th>
                    <th class="px-5 py-3 text-left">Status</th>
                    <th class="px-5 py-3 text-left">Biaya</th>
                    <th class="px-5 py-3 text-left">Tanggal</th>
                    <th class="px-5 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($shipments as $shipment)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3 font-mono text-xs font-semibold text-[#1a2b5c]">{{ $shipment->tracking_number }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $shipment->sender?->name ?? '-' }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $shipment->receiver?->name ?? '-' }}</td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $shipment->originBranch?->city }} → {{ $shipment->destinationBranch?->city }}</td>
                    <td class="px-5 py-3"><x-status-badge :status="$shipment->status"/></td>
                    <td class="px-5 py-3 text-gray-700">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $shipment->shipment_date ? \Carbon\Carbon::parse($shipment->shipment_date)->format('d/m/Y') : '-' }}</td>
                    <td class="px-5 py-3">
                        <a href="{{ route('admin.shipments.show', $shipment) }}" class="text-[#1a2b5c] hover:text-[#6abf2e] font-semibold text-xs transition-colors">Detail →</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-12 text-gray-400 text-sm">Tidak ada data pengiriman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($shipments->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $shipments->links() }}</div>
    @endif
</div>
@endsection
