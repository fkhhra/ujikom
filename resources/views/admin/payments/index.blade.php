@extends('layouts.dashboard')
@section('title', 'Pembayaran')
@section('page-title', 'Manajemen Pembayaran')

@section('content')
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="p-4 sm:p-5 border-b border-gray-50">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor resi..." class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none">
            </div>
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="paid" {{ request('status')==='paid' ? 'selected' : '' }}>Lunas</option>
                <option value="failed" {{ request('status')==='failed' ? 'selected' : '' }}>Gagal</option>
            </select>
            <button type="submit" class="bg-[#1a2d5a] text-white text-sm font-semibold px-5 py-2 rounded-lg">Filter</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">No. Resi</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Pengirim</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Metode</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jumlah</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Tanggal</th>
                <th class="px-5 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($payments as $p)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3.5 font-mono text-xs font-semibold text-[#1a2d5a]">{{ $p->shipment?->tracking_number ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-600 hidden sm:table-cell">{{ $p->shipment?->sender?->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-500 capitalize hidden md:table-cell">{{ str_replace('_', ' ', $p->payment_method ?? '-') }}</td>
                    <td class="px-5 py-3.5 font-semibold text-gray-700">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $p->payment_status === 'paid' ? 'bg-green-100 text-green-700' : ($p->payment_status === 'failed' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $p->payment_status === 'paid' ? 'Lunas' : ($p->payment_status === 'failed' ? 'Gagal' : 'Menunggu') }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-400 text-xs hidden lg:table-cell">{{ $p->payment_date ? \Carbon\Carbon::parse($p->payment_date)->format('d M Y') : '-' }}</td>
                    <td class="px-5 py-3.5">
                        @if($p->payment_status === 'paid')
                            <a href="{{ route('admin.payments.print-receipt', $p) }}" target="_blank" class="text-[#6abf2e] text-xs font-semibold hover:underline">Cetak</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-gray-400">Tidak ada data pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())<div class="p-4 border-t border-gray-50">{{ $payments->links() }}</div>@endif
</div>
@endsection
