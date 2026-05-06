@extends('layouts.customer')
@section('title', 'Pembayaran - ' . $payment->shipment?->tracking_number)

@section('content')
<div class="max-w-lg mx-auto">
    <div class="mb-5">
        <a href="{{ route('customer.track', $payment->shipment) }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1a2d5a]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    @if($payment->payment_status === 'paid')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h2 class="text-xl font-extrabold text-[#1a2d5a] mb-2">Pembayaran Berhasil!</h2>
            <p class="text-gray-500 text-sm mb-6">Paket Anda sedang dalam proses pengiriman.</p>
            <a href="{{ route('customer.track', $payment->shipment) }}" class="inline-flex items-center gap-2 bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
                Lacak Paket
            </a>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between mb-5 pb-5 border-b border-gray-100">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Nomor Resi</p>
                    <p class="font-mono font-semibold text-[#1a2d5a]">{{ $payment->shipment?->tracking_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 mb-0.5">Total Bayar</p>
                    <p class="text-xl font-extrabold text-[#6abf2e]">Rp {{ number_format($payment->amount,0,',','.') }}</p>
                </div>
            </div>

            {{-- Payment method --}}
            @php
                $method = $payment->midtrans_bank ?? $payment->payment_method;
                $isQris = $method === 'qris';
                $isGopay = $method === 'gopay';
                $isMandiri = $method === 'mandiri';
                $isVa = in_array($method, ['bca','bri','bni','bsi']);
            @endphp

            <div class="mb-5">
                <p class="text-sm font-semibold text-gray-700 mb-3">Cara Pembayaran</p>

                @if($isQris || $isGopay)
                    @if($payment->midtrans_payment_code)
                        <div class="text-center p-4 bg-gray-50 rounded-xl border border-gray-200">
                            @if($isQris)
                                <p class="text-xs text-gray-500 mb-3">Scan QR Code dengan aplikasi pembayaran Anda</p>
                                <img src="{{ $payment->midtrans_payment_code }}" alt="QRIS" class="w-48 h-48 mx-auto object-contain mb-3">
                                <a href="{{ route('customer.payments.download-qris', $payment) }}" class="text-xs text-[#6abf2e] font-semibold hover:underline">Unduh QR Code</a>
                            @else
                                <p class="text-xs text-gray-500 mb-3">Klik tombol berikut untuk membuka GoPay</p>
                                <a href="{{ $payment->midtrans_payment_code }}" class="inline-flex items-center gap-2 bg-[#00AED6] text-white font-semibold px-5 py-2.5 rounded-xl text-sm">
                                    Buka GoPay
                                </a>
                            @endif
                        </div>
                    @endif

                @elseif($isMandiri)
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl space-y-3 text-sm">
                        <div class="flex justify-between"><span class="text-gray-600">Biller Code</span><span class="font-bold text-[#1a2d5a]">{{ $payment->midtrans_biller_code }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-600">Bill Key</span><span class="font-bold text-[#1a2d5a]">{{ $payment->midtrans_va_number }}</span></div>
                        <p class="text-xs text-gray-500">Bayar melalui Mandiri Online / ATM menggunakan Biller Code dan Bill Key di atas.</p>
                    </div>

                @elseif($isVa && $payment->midtrans_va_number)
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl space-y-3">
                        <div class="text-center">
                            <p class="text-xs text-gray-500 mb-1">Nomor Virtual Account {{ strtoupper($method) }}</p>
                            <p class="text-2xl font-extrabold text-[#1a2d5a] tracking-widest">{{ $payment->midtrans_va_number }}</p>
                        </div>
                        <button onclick="navigator.clipboard.writeText('{{ $payment->midtrans_va_number }}').then(() => this.textContent = 'Tersalin!')" class="w-full bg-white border border-blue-300 text-blue-700 font-semibold py-2 rounded-lg text-sm hover:bg-blue-50 transition-colors">
                            Salin Nomor VA
                        </button>
                        <p class="text-xs text-gray-500 text-center">Transfer tepat sesuai nominal. Pembayaran otomatis terverifikasi.</p>
                    </div>
                @endif
            </div>

            {{-- Status check --}}
            <div id="status-section" class="p-3 bg-yellow-50 border border-yellow-200 rounded-xl flex items-center gap-3 mb-4">
                <div id="status-icon">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p id="status-text" class="text-sm text-yellow-700 font-medium">Menunggu pembayaran...</p>
            </div>

            <button onclick="checkPaymentStatus()" class="w-full border border-[#6abf2e] text-[#6abf2e] font-semibold py-2.5 rounded-xl text-sm hover:bg-[#6abf2e]/5 transition-colors">
                Cek Status Pembayaran
            </button>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
async function checkPaymentStatus() {
    const statusText = document.getElementById('status-text');
    statusText.textContent = 'Memeriksa status...';

    const res = await fetch('{{ route("customer.payments.status", $payment) }}');
    const data = await res.json();

    if (data.status === 'paid') {
        document.getElementById('status-section').className = 'p-3 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 mb-4';
        document.getElementById('status-icon').innerHTML = '<svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>';
        statusText.textContent = 'Pembayaran berhasil! Halaman akan diperbarui...';
        statusText.className = 'text-sm text-green-700 font-medium';
        setTimeout(() => location.reload(), 1500);
    } else if (data.status === 'failed') {
        document.getElementById('status-section').className = 'p-3 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3 mb-4';
        statusText.textContent = 'Pembayaran gagal atau kedaluwarsa.';
        statusText.className = 'text-sm text-red-700 font-medium';
    } else {
        statusText.textContent = 'Menunggu pembayaran...';
    }
}

// Auto check every 10 seconds
@if($payment->payment_status !== 'paid')
setInterval(checkPaymentStatus, 10000);
@endif
</script>
@endpush
