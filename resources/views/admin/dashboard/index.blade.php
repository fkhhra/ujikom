@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data & aktivitas terkini')

@push('styles')
<style>
.stat-card { background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #f1f5f9; }
</style>
@endpush

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="stat-card">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Pengiriman</p>
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">{{ number_format($totalShipments) }}</p>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Customer</p>
            <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">{{ number_format($totalCustomers) }}</p>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pendapatan Bulan Ini</p>
            <div class="w-9 h-9 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Pendapatan</p>
            <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

{{-- Status row --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">
        <p class="text-2xl font-extrabold text-yellow-700">{{ $pendingShipments }}</p>
        <p class="text-xs font-semibold text-yellow-600 mt-1">Menunggu</p>
    </div>
    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 text-center">
        <p class="text-2xl font-extrabold text-indigo-700">{{ $inTransitShipments }}</p>
        <p class="text-xs font-semibold text-indigo-600 mt-1">Dalam Perjalanan</p>
    </div>
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
        <p class="text-2xl font-extrabold text-green-700">{{ $deliveredShipments }}</p>
        <p class="text-xs font-semibold text-green-600 mt-1">Terkirim</p>
    </div>
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
        <p class="text-2xl font-extrabold text-red-700">{{ $cancelledShipments }}</p>
        <p class="text-xs font-semibold text-red-600 mt-1">Dibatalkan</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Chart --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <h3 class="font-bold text-[#1a2d5a] mb-4">Pendapatan 12 Bulan Terakhir</h3>
        <canvas id="revenueChart" height="100"></canvas>
    </div>

    {{-- Quick stats --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <h3 class="font-bold text-[#1a2d5a] mb-4">Info Operasional</h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Total Kurir</span>
                </div>
                <span class="font-bold text-[#1a2d5a]">{{ $totalCouriers }}</span>
            </div>
            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-[#6abf2e] rounded-full"></div>
                    <span class="text-sm text-gray-600">Total Cabang</span>
                </div>
                <span class="font-bold text-[#1a2d5a]">{{ $totalBranches }}</span>
            </div>
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Pengiriman Aktif</span>
                </div>
                <span class="font-bold text-[#1a2d5a]">{{ $inTransitShipments }}</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-50">
            <a href="{{ route('admin.shipments.index') }}" class="block w-full text-center bg-[#1a2d5a] hover:bg-[#162250] text-white text-sm font-semibold py-2.5 rounded-xl transition-colors">
                Lihat Semua Pengiriman
            </a>
        </div>
    </div>
</div>

{{-- Recent shipments --}}
<div class="mt-6 bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="flex items-center justify-between p-5 border-b border-gray-50">
        <h3 class="font-bold text-[#1a2d5a]">Pengiriman Terbaru</h3>
        <a href="{{ route('admin.shipments.index') }}" class="text-sm text-[#6abf2e] font-semibold hover:underline">Lihat semua →</a>
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
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentShipments as $s)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3.5 font-mono text-xs font-semibold text-[#1a2d5a]">{{ $s->tracking_number }}</td>
                    <td class="px-5 py-3.5 text-gray-600 hidden sm:table-cell">{{ $s->sender?->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs hidden md:table-cell">{{ $s->originBranch?->city }} → {{ $s->destinationBranch?->city }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $s->status_badge }}">
                            {{ $s->status_label }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-700 font-semibold hidden lg:table-cell">Rp {{ number_format($s->total_price, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5">
                        <a href="{{ route('admin.shipments.show', $s) }}" class="text-[#6abf2e] hover:text-[#5aaa25] text-xs font-semibold">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-8 text-center text-gray-400 text-sm">Belum ada data pengiriman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const chartData = @json($chartData);
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: chartData.map(d => d.label),
        datasets: [{
            label: 'Pendapatan',
            data: chartData.map(d => d.revenue),
            backgroundColor: 'rgba(106,191,46,0.15)',
            borderColor: '#6abf2e',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => 'Rp ' + Number(ctx.raw).toLocaleString('id-ID')
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { callback: v => 'Rp ' + Number(v).toLocaleString('id-ID'), font: { size: 10 } },
                grid: { color: '#f1f5f9' }
            },
            x: { ticks: { font: { size: 10 } }, grid: { display: false } }
        }
    }
});
</script>
@endpush
