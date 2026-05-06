@extends('layouts.customer')
@section('title', 'Dashboard Customer')

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Terkirim</p>
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">{{ $totalSent }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Diterima</p>
            <div class="w-9 h-9 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">{{ $totalReceived }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Sedang Dikirim</p>
            <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-[#1a2d5a]">{{ $activeShipments }}</p>
    </div>
</div>

{{-- Tab Pengiriman --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="border-b border-gray-100 px-5">
        <div class="flex gap-1 -mb-px">
            <a href="{{ route('customer.dashboard', ['tab' => 'outgoing']) }}"
               class="px-4 py-3.5 text-sm font-semibold border-b-2 transition-colors {{ $tab === 'outgoing' ? 'border-[#6abf2e] text-[#6abf2e]' : 'border-transparent text-gray-500 hover:text-[#1a2d5a]' }}">
                Pengiriman Keluar
            </a>
            <a href="{{ route('customer.dashboard', ['tab' => 'incoming']) }}"
               class="px-4 py-3.5 text-sm font-semibold border-b-2 transition-colors {{ $tab === 'incoming' ? 'border-[#6abf2e] text-[#6abf2e]' : 'border-transparent text-gray-500 hover:text-[#1a2d5a]' }}">
                Paket Masuk
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">No. Resi</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">{{ $tab === 'outgoing' ? 'Penerima' : 'Pengirim' }}</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Rute</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Pembayaran</th>
                <th class="px-5 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($shipments as $s)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3.5 font-mono text-xs font-semibold text-[#1a2d5a]">{{ $s->tracking_number }}</td>
                    <td class="px-5 py-3.5 text-gray-600 hidden sm:table-cell">{{ $tab === 'outgoing' ? $s->receiver?->name : $s->sender?->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-400 text-xs hidden md:table-cell">{{ $s->originBranch?->city }} → {{ $s->destinationBranch?->city }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $s->status_badge }}">{{ $s->status_label }}</span>
                    </td>
                    <td class="px-5 py-3.5 hidden lg:table-cell">
                        @if($s->payment && $s->payment->payment_status === 'paid')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Lunas</span>
                        @elseif($s->payment && $s->payer_type === 'sender' && $tab === 'outgoing')
                            <a href="{{ route('customer.payments.checkout', $s->payment) }}" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 hover:bg-yellow-200">Bayar Sekarang</a>
                        @elseif(!$s->payment && $s->payer_type === 'sender' && $tab === 'outgoing')
                            <form action="{{ route('customer.payments.pay', $s) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="payment_method" value="qris">
                                <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#6abf2e]/10 text-[#6abf2e] hover:bg-[#6abf2e]/20">Bayar</button>
                            </form>
                        @else
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        <a href="{{ route('customer.track', $s) }}" class="text-[#6abf2e] text-xs font-semibold hover:underline">Lacak</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400">Belum ada pengiriman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($shipments->hasPages())
    <div class="p-4 border-t border-gray-50">{{ $shipments->links() }}</div>
    @endif
</div>
@endsection
