@extends('layouts.dashboard')
@section('title', 'Konfirmasi Pembayaran')
@section('page-title', 'Konfirmasi Pembayaran Tunai')

@section('content')
<div class="max-w-lg">
    <a href="{{ route('cashier.payments.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1a2d5a] mb-5">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Kembali
    </a>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="mb-5 p-4 bg-gray-50 rounded-xl text-sm space-y-2">
            <div class="flex justify-between"><span class="text-gray-500">No. Resi</span><span class="font-mono font-semibold text-[#1a2d5a]">{{ $shipment->tracking_number }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Pengirim</span><span class="font-medium">{{ $shipment->sender?->name }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Penerima</span><span class="font-medium">{{ $shipment->receiver?->name }}</span></div>
            <div class="flex justify-between pt-2 border-t border-gray-200"><span class="font-semibold text-gray-700">Total Bayar</span><span class="font-bold text-[#6abf2e] text-lg">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</span></div>
        </div>

        <form action="{{ route('cashier.payments.cash', $shipment) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Metode Pembayaran</label>
                <div class="p-3 bg-[#6abf2e]/5 border border-[#6abf2e]/20 rounded-xl flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="text-sm font-semibold text-[#1a2d5a]">Tunai (Cash)</span>
                </div>
                <input type="hidden" name="payment_method" value="cash">
            </div>
            <button type="submit" class="w-full bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-bold py-3 rounded-xl transition-colors">
                Konfirmasi & Tandai Lunas
            </button>
            <a href="{{ route('cashier.payments.index') }}" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition-colors text-sm">
                Batal
            </a>
        </form>
    </div>
</div>
@endsection
