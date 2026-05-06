@extends('layouts.dashboard')
@section('title', 'Pembayaran')
@section('page-title', 'Pembayaran')

@section('content')
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="p-4 border-b border-gray-50">
        <form method="GET" class="flex gap-3">
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="paid" {{ request('status')==='paid' ? 'selected' : '' }}>Lunas</option>
            </select>
            <button type="submit" class="bg-[#1a2d5a] text-white text-sm font-semibold px-5 py-2 rounded-lg">Filter</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">No. Resi</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Pengirim</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jumlah</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="px-5 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($payments as $p)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3.5 font-mono text-xs font-semibold text-[#1a2d5a]">{{ $p->shipment?->tracking_number ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-600 hidden sm:table-cell">{{ $p->shipment?->sender?->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 font-semibold text-gray-700">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $p->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $p->payment_status === 'paid' ? 'Lunas' : 'Menunggu' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        @if($p->payment_status === 'paid')
                            <a href="{{ route('cashier.payments.print', $p) }}" target="_blank" class="text-[#6abf2e] text-xs font-semibold hover:underline">Cetak</a>
                        @elseif($p->shipment)
                            <a href="{{ route('cashier.payments.create', $p->shipment) }}" class="text-[#1a2d5a] text-xs font-semibold hover:underline">Bayar</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">Tidak ada data pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())<div class="p-4 border-t border-gray-50">{{ $payments->links() }}</div>@endif
</div>
@endsection
