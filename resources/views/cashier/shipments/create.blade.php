@extends('layouts.dashboard')
@section('title', 'Buat Pengiriman - Kasir Trivo')
@section('sidebar')
@include('components.cashier-sidebar')
@endsection
@section('main-content')
<div class="mb-6">
    <a href="{{ route('cashier.shipments.index') }}" class="text-sm text-gray-500 hover:text-[#1a2b5c] transition-colors">← Kembali</a>
    <h1 class="text-2xl font-extrabold text-[#1a2b5c] mt-1">Buat Pengiriman Baru</h1>
</div>

<form method="POST" action="{{ route('cashier.shipments.store') }}" id="shipment-form">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 space-y-5">

            {{-- PENGIRIM & PENERIMA --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <h2 class="font-bold text-[#1a2b5c] mb-4 text-sm">Data Pengirim & Penerima</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pengirim</label>
                        <select name="sender_id" required
                            class="w-full border @error('sender_id') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                            <option value="">Pilih pengirim...</option>
                            @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ old('sender_id')==$c->id?'selected':'' }}>{{ $c->name }} — {{ $c->phone }}</option>
                            @endforeach
                        </select>
                        @error('sender_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Penerima</label>
                        <select name="receiver_id" required
                            class="w-full border @error('receiver_id') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                            <option value="">Pilih penerima...</option>
                            @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ old('receiver_id')==$c->id?'selected':'' }}>{{ $c->name }} — {{ $c->phone }}</option>
                            @endforeach
                        </select>
                        @error('receiver_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- CABANG & RUTE --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <h2 class="font-bold text-[#1a2b5c] mb-4 text-sm">Rute Pengiriman</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cabang Asal</label>
                        <select name="origin_branch_id" required id="origin-branch"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                            @foreach($branches as $b)
                            <option value="{{ $b->id }}" {{ ($userBranch && $userBranch->id==$b->id) || old('origin_branch_id')==$b->id?'selected':'' }}>{{ $b->name }} — {{ $b->city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cabang Tujuan</label>
                        <select name="destination_branch_id" required id="dest-branch"
                            class="w-full border @error('destination_branch_id') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                            <option value="">Pilih cabang tujuan...</option>
                            @foreach($branches as $b)
                            <option value="{{ $b->id }}" {{ old('destination_branch_id')==$b->id?'selected':'' }}>{{ $b->name }} — {{ $b->city }}</option>
                            @endforeach
                        </select>
                        @error('destination_branch_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tarif</label>
                        <select name="rate_id" required id="rate-select"
                            class="w-full border @error('rate_id') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                            <option value="">Pilih tarif...</option>
                            @foreach($rates as $r)
                            <option value="{{ $r->id }}" data-price="{{ $r->price_per_kg }}" {{ old('rate_id')==$r->id?'selected':'' }}>
                                {{ $r->origin_city }} → {{ $r->destination_city }} | Rp {{ number_format($r->price_per_kg,0,',','.') }}/kg | {{ $r->estimated_days }} hari
                            </option>
                            @endforeach
                        </select>
                        @error('rate_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Kirim</label>
                        <input type="date" name="shipment_date" value="{{ old('shipment_date', date('Y-m-d')) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                    </div>
                </div>
            </div>

            {{-- ITEMS --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-[#1a2b5c] text-sm">Item Paket</h2>
                    <button type="button" id="add-item" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-3 py-1.5 rounded-lg text-xs transition-all">+ Tambah Item</button>
                </div>
                @error('items')<p class="text-red-500 text-xs mb-2">{{ $message }}</p>@enderror
                <div id="items-container" class="space-y-3">
                    <div class="item-row grid grid-cols-12 gap-2 items-end">
                        <div class="col-span-6">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Item</label>
                            <input type="text" name="items[0][item_name]" required placeholder="Nama barang..."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none item-name">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Qty</label>
                            <input type="number" name="items[0][quantity]" required min="1" value="1"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                        </div>
                        <div class="col-span-3">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Berat (kg)</label>
                            <input type="number" name="items[0][weight]" required min="0.01" step="0.01" placeholder="0.00"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none item-weight">
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="text-gray-300 text-lg select-none mt-1">—</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PEMBAYAR --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <h2 class="font-bold text-[#1a2b5c] mb-4 text-sm">Pembayar</h2>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="payer_type" value="sender" {{ old('payer_type','sender')=='sender'?'checked':'' }} class="w-4 h-4 text-[#1a2b5c]">
                        <span class="text-sm font-medium text-gray-700">Pengirim</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="payer_type" value="receiver" {{ old('payer_type')=='receiver'?'checked':'' }} class="w-4 h-4 text-[#1a2b5c]">
                        <span class="text-sm font-medium text-gray-700">Penerima</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- SUMMARY SIDEBAR --}}
        <div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm sticky top-24">
                <h3 class="font-bold text-[#1a2b5c] text-sm mb-4">Ringkasan</h3>
                <div class="space-y-3 text-sm mb-5">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Total Berat</span>
                        <span class="font-semibold" id="summary-weight">0 kg</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tarif/kg</span>
                        <span class="font-semibold" id="summary-rate">Rp 0</span>
                    </div>
                    <div class="border-t border-gray-100 pt-2 flex justify-between">
                        <span class="font-semibold text-gray-700">Estimasi Total</span>
                        <span class="font-bold text-[#6abf2e] text-base" id="summary-total">Rp 0</span>
                    </div>
                </div>
                <button type="submit" class="w-full bg-[#1a2b5c] hover:bg-[#111e42] text-white font-semibold py-3 rounded-lg text-sm transition-all">
                    Simpan Pengiriman
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
let itemCount = 1;
const fmt = n => 'Rp ' + Intl.NumberFormat('id-ID').format(n);

function calcTotal() {
    let totalWeight = 0;
    document.querySelectorAll('.item-weight').forEach(el => {
        totalWeight += parseFloat(el.value) || 0;
    });
    const rateOption = document.getElementById('rate-select').selectedOptions[0];
    const pricePerKg = parseFloat(rateOption?.dataset.price) || 0;
    const total = totalWeight * pricePerKg;
    document.getElementById('summary-weight').textContent = totalWeight.toFixed(2) + ' kg';
    document.getElementById('summary-rate').textContent = fmt(pricePerKg);
    document.getElementById('summary-total').textContent = fmt(total);
}

document.getElementById('rate-select').addEventListener('change', calcTotal);
document.getElementById('items-container').addEventListener('input', calcTotal);

document.getElementById('add-item').addEventListener('click', function() {
    const container = document.getElementById('items-container');
    const row = document.createElement('div');
    row.className = 'item-row grid grid-cols-12 gap-2 items-end';
    row.innerHTML = `
        <div class="col-span-6">
            <input type="text" name="items[${itemCount}][item_name]" required placeholder="Nama barang..."
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
        </div>
        <div class="col-span-2">
            <input type="number" name="items[${itemCount}][quantity]" required min="1" value="1"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
        </div>
        <div class="col-span-3">
            <input type="number" name="items[${itemCount}][weight]" required min="0.01" step="0.01" placeholder="0.00"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none item-weight">
        </div>
        <div class="col-span-1 flex justify-center">
            <button type="button" onclick="this.closest('.item-row').remove(); calcTotal();"
                class="w-7 h-7 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>`;
    container.appendChild(row);
    itemCount++;
});
</script>
@endpush
