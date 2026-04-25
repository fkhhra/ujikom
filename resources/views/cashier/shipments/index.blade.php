@extends('layouts.dashboard')
@section('title', 'Pengiriman - Kasir Trivo')
@section('sidebar')
@include('components.cashier-sidebar')
@endsection
@section('main-content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-[#1a2b5c]">Pengiriman</h1>
        <p class="text-gray-500 text-sm">Daftar pengiriman di cabang Anda</p>
    </div>
    <a href="{{ route('cashier.shipments.create') }}" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-4 py-2 rounded-lg text-sm transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Buat Pengiriman
    </a>
</div>

{{-- SCAN RESI --}}
<div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm mb-5">
    <form method="POST" action="{{ route('cashier.shipments.scan') }}" class="flex gap-3 flex-wrap items-end">
        @csrf
        <div class="flex-1 min-w-56">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Scan / Cari Resi</label>
            <input type="text" name="tracking_number" placeholder="Masukkan nomor resi..." required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none uppercase">
        </div>
        <button type="submit" class="bg-[#1a2b5c] hover:bg-[#111e42] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all">Cari</button>
    </form>
</div>

<div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Cari Resi</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nomor resi..."
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                <option value="">Semua</option>
                @foreach(['pending'=>'Menunggu','picked_up'=>'Diambil','in_transit'=>'Transit','arrived_at_branch'=>'Di Cabang','out_for_delivery'=>'Diantar','delivered'=>'Terkirim','cancelled'=>'Dibatalkan'] as $v=>$l)
                <option value="{{ $v }}" {{ request('status')==$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-[#1a2b5c] hover:bg-[#111e42] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all">Filter</button>
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
                    <th class="px-5 py-3 text-left">Tujuan</th>
                    <th class="px-5 py-3 text-left">Status</th>
                    <th class="px-5 py-3 text-left">Bayar</th>
                    <th class="px-5 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($shipments as $shipment)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3 font-mono text-xs font-semibold text-[#1a2b5c]">{{ $shipment->tracking_number }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $shipment->sender?->name }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $shipment->receiver?->name }}</td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $shipment->destinationBranch?->city }}</td>
                    <td class="px-5 py-3"><x-status-badge :status="$shipment->status"/></td>
                    <td class="px-5 py-3"><x-status-badge :status="$shipment->payment?->payment_status ?? 'unpaid'"/></td>
                    <td class="px-5 py-3">
                        <a href="{{ route('cashier.shipments.show', $shipment) }}" class="text-[#1a2b5c] hover:text-[#6abf2e] font-semibold text-xs">Detail →</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400 text-sm">Tidak ada pengiriman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($shipments->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $shipments->links() }}</div>
    @endif
</div>
@endsection
