@extends('layouts.dashboard')
@section('title', 'Dashboard Admin - Trivo')

@section('sidebar')
@include('components.admin-sidebar')
@endsection

@section('main-content')
<div class="mb-6">
    <h1 class="text-2xl font-extrabold text-[#1a2b5c]">Dashboard</h1>
    <p class="text-gray-500 text-sm">Ringkasan operasional Trivo</p>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Pengiriman</p>
            <div class="w-9 h-9 bg-[#1a2b5c]/10 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-[#1a2b5c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <p class="text-3xl font-extrabold text-[#1a2b5c]">{{ number_format($totalShipments) }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pelanggan</p>
            <div class="w-9 h-9 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-[#6abf2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <p class="text-3xl font-extrabold text-[#1a2b5c]">{{ number_format($totalCustomers) }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pendapatan Bulan Ini</p>
            <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2b5c]">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Cabang Aktif</p>
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>
        <p class="text-3xl font-extrabold text-[#1a2b5c]">{{ $totalBranches }}</p>
    </div>
</div>

{{-- CHART & STATUS --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <h2 class="font-bold text-[#1a2b5c] mb-4 text-sm">Pendapatan 12 Bulan Terakhir</h2>
        <canvas id="revenueChart" class="max-h-64"></canvas>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <h2 class="font-bold text-[#1a2b5c] mb-6 text-sm">Status Pengiriman</h2>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3.5 bg-amber-50 rounded-2xl border border-amber-100/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider font-bold text-amber-600/70">Menunggu</p>
                        <p class="text-sm font-bold text-amber-900">Pending</p>
                    </div>
                </div>
                <span class="text-2xl font-black text-amber-600">{{ $pendingShipments }}</span>
            </div>

            <div class="flex items-center justify-between p-3.5 bg-blue-50 rounded-2xl border border-blue-100/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider font-bold text-blue-600/70">Proses</p>
                        <p class="text-sm font-bold text-blue-900">In Transit</p>
                    </div>
                </div>
                <span class="text-2xl font-black text-blue-600">{{ $inTransitShipments }}</span>
            </div>

            <div class="flex items-center justify-between p-3.5 bg-emerald-50 rounded-2xl border border-emerald-100/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider font-bold text-emerald-600/70">Selesai</p>
                        <p class="text-sm font-bold text-emerald-900">Terkirim</p>
                    </div>
                </div>
                <span class="text-2xl font-black text-emerald-600">{{ $deliveredShipments }}</span>
            </div>

            <div class="flex items-center justify-between p-3.5 bg-rose-50 rounded-2xl border border-rose-100/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider font-bold text-rose-600/70">Batal</p>
                        <p class="text-sm font-bold text-rose-900">Cancelled</p>
                    </div>
                </div>
                <span class="text-2xl font-black text-rose-600">{{ $cancelledShipments }}</span>
            </div>
        </div>
    </div>
</div>

{{-- RECENT SHIPMENTS --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-bold text-[#1a2b5c] text-sm">Pengiriman Terbaru</h2>
        <a href="{{ route('admin.shipments.index') }}" class="text-xs text-[#6abf2e] font-semibold hover:text-[#4e9020]">Lihat semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">Resi</th>
                    <th class="px-5 py-3 text-left">Pengirim</th>
                    <th class="px-5 py-3 text-left">Rute</th>
                    <th class="px-5 py-3 text-left">Status</th>
                    <th class="px-5 py-3 text-left">Biaya</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                $statusMap = ['pending'=>['Menunggu','bg-yellow-100 text-yellow-700'],'picked_up'=>['Diambil','bg-blue-100 text-blue-700'],'in_transit'=>['Transit','bg-indigo-100 text-indigo-700'],'arrived_at_branch'=>['Di Cabang','bg-purple-100 text-purple-700'],'out_for_delivery'=>['Diantar','bg-orange-100 text-orange-700'],'delivered'=>['Terkirim','bg-green-100 text-green-700'],'cancelled'=>['Batal','bg-red-100 text-red-700']];
                @endphp
                @foreach($recentShipments as $shipment)
                @php $s = $statusMap[$shipment->status] ?? [$shipment->status, 'bg-gray-100 text-gray-700']; @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3 font-mono text-xs font-semibold text-[#1a2b5c]">
                        <a href="{{ route('admin.shipments.show', $shipment) }}" class="hover:text-[#6abf2e]">{{ $shipment->tracking_number }}</a>
                    </td>
                    <td class="px-5 py-3 text-gray-700">{{ $shipment->sender?->name }}</td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $shipment->originBranch?->city }} → {{ $shipment->destinationBranch?->city }}</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $s[1] }}">{{ $s[0] }}</span></td>
                    <td class="px-5 py-3 text-gray-700">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const chartData = @json($chartData);
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: chartData.map(d => d.label),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: chartData.map(d => d.revenue),
            backgroundColor: 'rgba(26, 43, 92, 0.15)',
            borderColor: '#1a2b5c',
            borderWidth: 2,
            borderRadius: 6,
            hoverBackgroundColor: 'rgba(106, 191, 46, 0.3)',
            hoverBorderColor: '#6abf2e',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: v => 'Rp ' + Intl.NumberFormat('id-ID').format(v),
                    font: { size: 11 }
                },
                grid: { color: 'rgba(0,0,0,0.04)' }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 } }
            }
        }
    }
});
</script>
@endpush
