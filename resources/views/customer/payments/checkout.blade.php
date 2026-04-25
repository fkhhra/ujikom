@extends('layouts.dashboard')
@section('title', 'Bayar Online - Trivo')
@section('sidebar')
@include('components.customer-sidebar')
@endsection
@section('main-content')
<div class="mb-6">
    <a href="{{ route('customer.dashboard') }}" class="text-sm text-gray-500 hover:text-[#1a2b5c] transition-colors">← Kembali</a>
    <h1 class="text-2xl font-extrabold text-[#1a2b5c] mt-1">Pembayaran Online</h1>
    <p class="text-gray-500 text-sm font-mono">{{ $payment->shipment?->tracking_number }}</p>
</div>

<div class="max-w-lg">
    {{-- TAGIHAN --}}
    <div class="bg-[#f0f7e8] border border-[#6abf2e]/30 rounded-2xl p-5 mb-5">
        <h3 class="font-bold text-[#1a2b5c] text-sm mb-3">Tagihan</h3>
        <div class="grid grid-cols-2 gap-2 text-sm">
            <div>
                <p class="text-xs text-gray-500">Rute</p>
                <p class="font-semibold">{{ $payment->shipment?->originBranch?->city }} → {{ $payment->shipment?->destinationBranch?->city }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Berat</p>
                <p class="font-semibold">{{ $payment->shipment?->total_weight }} kg</p>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-[#6abf2e]/20 flex justify-between">
            <span class="font-bold text-gray-700">Total</span>
            <span class="text-2xl font-extrabold text-[#6abf2e]">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- PILIH METODE --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <h3 class="font-bold text-[#1a2b5c] text-sm mb-4">Pilih Metode Pembayaran</h3>
        <form method="POST" action="{{ route('customer.payments.pay', $payment) }}" class="space-y-4">
            @csrf
            <div class="space-y-2">
                @foreach([
                    'transfer' => ['Transfer Bank', '🏦', 'BCA / BNI / Mandiri / BRI'],
                    'qris'     => ['QRIS', '📱', 'Scan QR dari aplikasi e-wallet'],
                ] as $val => [$label, $icon, $desc])
                <label class="flex items-center gap-3 border-2 rounded-xl p-4 cursor-pointer transition-all
                    {{ old('payment_method') == $val ? 'border-[#1a2b5c] bg-[#1a2b5c]/5' : 'border-gray-200 hover:border-[#1a2b5c]/40' }}">
                    <input type="radio" name="payment_method" value="{{ $val }}" class="w-4 h-4 text-[#1a2b5c]"
                        {{ old('payment_method') == $val ? 'checked' : '' }}>
                    <span class="text-xl">{{ $icon }}</span>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $label }}</p>
                        <p class="text-xs text-gray-500">{{ $desc }}</p>
                    </div>
                </label>
                @endforeach
            </div>
            @error('payment_method')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Referensi / Bukti Transfer</label>
                <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                    placeholder="Masukkan nomor referensi..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
            </div>

            <button type="submit" class="w-full bg-[#6abf2e] hover:bg-[#4e9020] text-white font-bold py-3.5 rounded-xl text-base transition-all">
                Konfirmasi Pembayaran
            </button>
        </form>
    </div>
</div>
@endsection
