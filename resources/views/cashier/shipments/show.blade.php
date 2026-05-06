@extends('layouts.dashboard')
@section('title', 'Detail Pengiriman')
@section('page-title', 'Detail Pengiriman')
@section('page-subtitle', $shipment->tracking_number)

@section('content')
<div class="mb-4 flex gap-3">
    <a href="{{ route('cashier.shipments.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1a2d5a]">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Kembali
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">
        {{-- Info --}}
        <div class="bg-[#1a2d5a] rounded-xl p-5 text-white">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Nomor Resi</p>
                    <p class="text-xl font-extrabold tracking-wider">{{ $shipment->tracking_number }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $shipment->status_badge }}">{{ $shipment->status_label }}</span>
            </div>
            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-white/10 text-sm">
                <div><p class="text-xs text-gray-400 mb-0.5">Pengirim</p><p class="font-semibold">{{ $shipment->sender?->name }}</p><p class="text-xs text-gray-400">{{ $shipment->sender?->phone }}</p></div>
                <div><p class="text-xs text-gray-400 mb-0.5">Penerima</p><p class="font-semibold">{{ $shipment->receiver?->name }}</p><p class="text-xs text-gray-400">{{ $shipment->receiver?->phone }}</p></div>
                <div><p class="text-xs text-gray-400 mb-0.5">Tujuan</p><p class="font-semibold">{{ $shipment->destinationBranch?->city }}</p></div>
                <div><p class="text-xs text-gray-400 mb-0.5">Total</p><p class="font-bold text-[#6abf2e]">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</p></div>
            </div>
        </div>

        {{-- Items --}}
        @if($shipment->items?->isNotEmpty())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-[#1a2d5a] mb-4">Item Paket</h3>
            <table class="w-full text-sm">
                <thead class="bg-gray-50"><tr>
                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-gray-500">Nama</th>
                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-gray-500">Qty</th>
                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-gray-500">Berat</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($shipment->items as $item)
                    <tr><td class="px-4 py-3 font-medium">{{ $item->name }}</td><td class="px-4 py-3 text-gray-500">{{ $item->quantity }}</td><td class="px-4 py-3 text-gray-500">{{ number_format($item->weight,2) }} kg</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Sidebar actions --}}
    <div class="space-y-4">
        {{-- Payment --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-[#1a2d5a] mb-4">Pembayaran</h3>
            @if($shipment->payment && $shipment->payment->payment_status === 'paid')
                <div class="flex items-center gap-2 p-3 bg-green-50 border border-green-200 rounded-xl mb-3">
                    <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="text-sm font-semibold text-green-700">Pembayaran Lunas</span>
                </div>
                <a href="{{ route('cashier.payments.print-receipt', $shipment->payment) }}" target="_blank" class="block w-full text-center bg-[#1a2d5a] hover:bg-[#162250] text-white text-sm font-semibold py-2.5 rounded-xl transition-colors">Cetak Struk</a>
            @elseif($shipment->payer_type === 'sender')
                <p class="text-sm text-gray-500 mb-3">Total: <span class="font-bold text-[#1a2d5a]">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</span></p>
                <form action="{{ route('cashier.shipments.pay-cash', $shipment) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">Tandai Lunas (Tunai)</button>
                </form>
            @else
                <p class="text-sm text-gray-500">COD — dibayar saat diterima penerima.</p>
            @endif
        </div>

        {{-- Print waybill --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-[#1a2d5a] mb-3">Dokumen</h3>
            <a href="{{ route('cashier.shipments.print-waybill', $shipment) }}" target="_blank" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl transition-colors">
                Cetak Waybill
            </a>
        </div>

        {{-- Receive --}}
        @if(in_array($shipment->status, ['picked_up', 'in_transit']))
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-[#1a2d5a] mb-3">Terima Paket</h3>
            <form action="{{ route('cashier.shipments.receive', $shipment) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">Tandai Tiba di Cabang</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
