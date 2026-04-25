@extends('layouts.dashboard')
@section('title', 'Pembayaran - Trivo Admin')

@section('sidebar')
@include('components.admin-sidebar')
@endsection

@section('main-content')
<div class="mb-6">
    <h1 class="text-2xl font-extrabold text-[#1a2b5c]">Pembayaran</h1>
    <p class="text-gray-500 text-sm">Data semua transaksi pembayaran</p>
</div>

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
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Menunggu</option>
                <option value="paid" {{ request('status')=='paid'?'selected':'' }}>Lunas</option>
                <option value="failed" {{ request('status')=='failed'?'selected':'' }}>Gagal</option>
            </select>
        </div>
        <button type="submit" class="bg-[#1a2b5c] hover:bg-[#111e42] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all">Filter</button>
        @if(request()->anyFilled(['search','status']))
        <a href="{{ route('admin.payments.index') }}" class="text-sm text-gray-500 hover:text-red-500 py-2">Reset</a>
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
                    <th class="px-5 py-3 text-left">Rute</th>
                    <th class="px-5 py-3 text-left">Jumlah</th>
                    <th class="px-5 py-3 text-left">Metode</th>
                    <th class="px-5 py-3 text-left">Status</th>
                    <th class="px-5 py-3 text-left">Tanggal</th>
                    <th class="px-5 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($payments as $payment)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3 font-mono text-xs font-semibold text-[#1a2b5c]">{{ $payment->shipment?->tracking_number }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $payment->shipment?->sender?->name ?? '-' }}</td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $payment->shipment?->originBranch?->city }} → {{ $payment->shipment?->destinationBranch?->city }}</td>
                    <td class="px-5 py-3 font-semibold text-gray-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td class="px-5 py-3 text-gray-600 capitalize">{{ $payment->payment_method ?? '-' }}</td>
                    <td class="px-5 py-3"><x-status-badge :status="$payment->payment_status"/></td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') : '-' }}</td>
                    <td class="px-5 py-3">
                        <a href="{{ route('admin.payments.print', $payment) }}" target="_blank" class="text-[#1a2b5c] hover:text-[#6abf2e] font-semibold text-xs transition-colors">Kwitansi</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-12 text-gray-400 text-sm">Belum ada data pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $payments->links() }}</div>
    @endif
</div>
@endsection
