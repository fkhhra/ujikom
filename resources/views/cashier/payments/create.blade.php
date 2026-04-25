@extends('layouts.dashboard')
@section('title', 'Terima Pembayaran - Kasir Trivo')
@section('sidebar')
@include('components.cashier-sidebar')
@endsection
@section('main-content')
<div class="mb-6">
    <a href="{{ route('cashier.shipments.show', $shipment) }}" class="text-sm text-gray-500 hover:text-[#1a2b5c] transition-colors">← Kembali ke Detail Pengiriman</a>
    <h1 class="text-2xl font-extrabold text-[#1a2b5c] mt-1">Terima Pembayaran</h1>
    <p class="text-gray-500 text-sm font-mono">{{ $shipment->tracking_number }}</p>
</div>

<div class="max-w-xl">
    {{-- RINGKASAN PENGIRIMAN --}}
    <div class="bg-[#f0f7e8] border border-[#6abf2e]/30 rounded-2xl p-5 mb-5">
        <h3 class="font-bold text-[#1a2b5c] text-sm mb-3">Ringkasan Pengiriman</h3>
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div>
                <p class="text-xs text-gray-500">Pengirim</p>
                <p class="font-semibold text-gray-800">{{ $shipment->sender?->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Penerima</p>
                <p class="font-semibold text-gray-800">{{ $shipment->receiver?->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Rute</p>
                <p class="font-semibold text-gray-800">{{ $shipment->originBranch?->city }} → {{ $shipment->destinationBranch?->city }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Total Berat</p>
                <p class="font-semibold text-gray-800">{{ $shipment->total_weight }} kg</p>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-[#6abf2e]/20 flex justify-between items-center">
            <span class="font-bold text-gray-700">Total Pembayaran</span>
            <span class="text-2xl font-extrabold text-[#6abf2e]">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- FORM PEMBAYARAN --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <h3 class="font-bold text-[#1a2b5c] text-sm mb-4">Konfirmasi Pembayaran</h3>
        <form method="POST" action="{{ route('cashier.payments.store', $shipment) }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Metode Pembayaran</label>
                <div class="grid grid-cols-3 gap-3">
                    @foreach(['cash' => ['Tunai','💵'], 'transfer' => ['Transfer','🏦'], 'qris' => ['QRIS','📱']] as $val => [$label, $icon])
                    <label class="flex flex-col items-center gap-1 border-2 rounded-xl p-3 cursor-pointer transition-all
                        {{ old('payment_method','cash') == $val ? 'border-[#1a2b5c] bg-[#1a2b5c]/5' : 'border-gray-200 hover:border-[#1a2b5c]/40' }}">
                        <input type="radio" name="payment_method" value="{{ $val }}" class="sr-only"
                            {{ old('payment_method','cash') == $val ? 'checked' : '' }}
                            onchange="document.querySelectorAll('.payment-method-label').forEach(el=>el.classList.remove('border-[#1a2b5c]','bg-[#1a2b5c]/5')); this.closest('label').classList.add('border-[#1a2b5c]','bg-[#1a2b5c]/5')">
                        <span class="text-2xl">{{ $icon }}</span>
                        <span class="text-xs font-semibold text-gray-700">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
                @error('payment_method')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jumlah Diterima (Rp)</label>
                <input type="number" name="amount_received" value="{{ old('amount_received', $shipment->total_price) }}"
                    required min="{{ $shipment->total_price }}" step="1000"
                    class="w-full border @error('amount_received') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none font-semibold text-lg"
                    id="amount-received" oninput="calcChange(this.value)">
                @error('amount_received')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div id="change-info" class="hidden p-3 bg-blue-50 border border-blue-100 rounded-lg">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Total Tagihan</span>
                    <span class="font-semibold">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm mt-1">
                    <span class="text-gray-600">Diterima</span>
                    <span class="font-semibold" id="received-display">Rp 0</span>
                </div>
                <div class="flex justify-between font-bold text-[#1a2b5c] mt-2 pt-2 border-t border-blue-100">
                    <span>Kembalian</span>
                    <span id="change-display">Rp 0</span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Catatan (Opsional)</label>
                <textarea name="notes" rows="2" placeholder="Nomor referensi, catatan tambahan..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none resize-none">{{ old('notes') }}</textarea>
            </div>
            <button type="submit" class="w-full bg-[#6abf2e] hover:bg-[#4e9020] text-white font-bold py-3.5 rounded-xl text-base transition-all">
                Konfirmasi Pembayaran Lunas
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const totalAmount = {{ $shipment->total_price }};
const fmt = n => 'Rp ' + Intl.NumberFormat('id-ID').format(n);

function calcChange(received) {
    const r = parseFloat(received) || 0;
    const change = r - totalAmount;
    const info = document.getElementById('change-info');
    if (r > 0) {
        info.classList.remove('hidden');
        document.getElementById('received-display').textContent = fmt(r);
        document.getElementById('change-display').textContent = fmt(Math.max(0, change));
        document.getElementById('change-display').className = change >= 0 ? 'text-green-600 font-bold' : 'text-red-500 font-bold';
    } else {
        info.classList.add('hidden');
    }
}
calcChange({{ $shipment->total_price }});
</script>
@endpush
