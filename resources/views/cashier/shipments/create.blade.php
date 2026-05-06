@extends('layouts.dashboard')
@section('title', 'Buat Pengiriman')
@section('page-title', 'Buat Pengiriman Baru')

@push('styles')
<style>
.form-section { background: white; border-radius: 0.75rem; border: 1px solid #f1f5f9; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 1.25rem; margin-bottom: 1rem; }
.form-section h4 { font-weight: 700; color: #1a2d5a; font-size: 0.875rem; margin-bottom: 1rem; padding-bottom: 0.625rem; border-bottom: 1px solid #f1f5f9; }
</style>
@endpush

@section('content')
<div class="w-full">
    <a href="{{ route('cashier.shipments.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1a2d5a] mb-5">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Kembali
    </a>

    <form action="{{ route('cashier.shipments.store') }}" method="POST" id="shipment-form">
        @csrf
        <div class="grid md:grid-cols-2 gap-5">
            {{-- Pengirim --}}
            <div class="form-section">
                <h4>Data Pengirim</h4>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pelanggan Pengirim</label>
                        <select name="sender_id" id="sender-select" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white @error('sender_id') border-red-400 @enderror">
                            <option value="">Pilih pelanggan...</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" {{ old('sender_id')==$c->id ? 'selected' : '' }}>{{ $c->name }} - {{ $c->phone }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" onclick="openNewCustomerModal('sender')" class="text-xs text-[#6abf2e] font-semibold hover:underline">+ Tambah pelanggan baru</button>
                </div>
            </div>

            {{-- Penerima --}}
            <div class="form-section">
                <h4>Data Penerima</h4>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pelanggan Penerima</label>
                        <select name="receiver_id" id="receiver-select" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white @error('receiver_id') border-red-400 @enderror">
                            <option value="">Pilih pelanggan...</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" {{ old('receiver_id')==$c->id ? 'selected' : '' }}>{{ $c->name }} - {{ $c->phone }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" onclick="openNewCustomerModal('receiver')" class="text-xs text-[#6abf2e] font-semibold hover:underline">+ Tambah pelanggan baru</button>
                </div>
            </div>
        </div>

        {{-- Rute --}}
        <div class="form-section">
            <h4>Rute Pengiriman</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Cabang Asal</label>
                    <select name="origin_branch_id" id="origin-branch" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white @error('origin_branch_id') border-red-400 @enderror">
                        @foreach($branches as $b)
                            <option value="{{ $b->id }}" data-city="{{ $b->city }}" {{ old('origin_branch_id', $userBranch?->id)==$b->id ? 'selected' : '' }}>{{ $b->city }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Cabang Tujuan</label>
                    <select name="destination_branch_id" id="destination-branch" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white @error('destination_branch_id') border-red-400 @enderror">
                        <option value="">Pilih tujuan</option>
                        @foreach($branches as $b)
                            <option value="{{ $b->id }}" data-city="{{ $b->city }}" {{ old('destination_branch_id')==$b->id ? 'selected' : '' }}>{{ $b->city }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tarif</label>
                    <select name="rate_id" id="rate-select" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white @error('rate_id') border-red-400 @enderror">
                        <option value="">Pilih tarif</option>
                        @foreach($rates as $r)
                            <option value="{{ $r->id }}" data-origin="{{ $r->origin_city }}" data-destination="{{ $r->destination_city }}" {{ old('rate_id')==$r->id ? 'selected' : '' }}>{{ $r->origin_city }} → {{ $r->destination_city }} (Rp {{ number_format($r->price_per_kg, 0, ',', '.') }}/kg)</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Kirim</label>
                    <input type="date" name="shipment_date" value="{{ old('shipment_date', date('Y-m-d')) }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none @error('shipment_date') border-red-400 @enderror">
                </div>
            </div>
            <div class="mt-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pihak yang Membayar</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="payer_type" value="sender" {{ old('payer_type','sender')==='sender' ? 'checked' : '' }} class="text-[#6abf2e] focus:ring-[#6abf2e]">
                        <span class="text-sm">Pengirim</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="payer_type" value="receiver" {{ old('payer_type')==='receiver' ? 'checked' : '' }} class="text-[#6abf2e] focus:ring-[#6abf2e]">
                        <span class="text-sm">Penerima (COD)</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Items --}}
        <div class="form-section">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-50">
                <h4 class="!mb-0 !pb-0 !border-0">Item Paket</h4>
                <button type="button" onclick="addItem()" class="inline-flex items-center gap-1.5 bg-[#6abf2e] hover:bg-[#5aaa25] text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Item
                </button>
            </div>
            <div id="items-container" class="space-y-3">
                <div class="item-row grid grid-cols-3 gap-3 p-3 bg-gray-50 rounded-xl">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Item</label>
                        <input type="text" name="items[0][item_name]" placeholder="Nama barang" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Qty</label>
                        <input type="number" name="items[0][quantity]" value="1" min="1" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Berat (kg)</label>
                        <input type="number" name="items[0][weight]" step="0.01" min="0.01" placeholder="0.5" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-bold px-8 py-3 rounded-xl text-sm transition-colors">
                Simpan Pengiriman
            </button>
            <a href="{{ route('cashier.shipments.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-xl text-sm transition-colors">Batal</a>
        </div>
    </form>
</div>

{{-- Modal tambah customer --}}
<div id="customer-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-[#1a2d5a]">Tambah Pelanggan Baru</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-3" id="modal-form">
            <input type="text" id="new-name" placeholder="Nama" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
            <input type="tel" id="new-phone" placeholder="No. HP" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
            <input type="text" id="new-city" placeholder="Kota" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
            <textarea id="new-address" rows="2" placeholder="Alamat" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none resize-none"></textarea>
            <input type="email" id="new-email" placeholder="Email (opsional)" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
        </div>
        <div id="modal-error" class="hidden mt-3 p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-lg"></div>
        <div class="flex gap-3 mt-5">
            <button onclick="saveCustomer()" class="flex-1 bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">Simpan</button>
            <button onclick="closeModal()" class="flex-1 bg-gray-100 text-gray-700 font-semibold py-2.5 rounded-xl text-sm">Batal</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let itemIndex = 1;
let targetSelect = null;

function addItem() {
    const container = document.getElementById('items-container');
    const div = document.createElement('div');
    div.className = 'item-row grid grid-cols-3 gap-3 p-3 bg-gray-50 rounded-xl relative';
    div.innerHTML = `
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">Nama Item</label><input type="text" name="items[${itemIndex}][item_name]" placeholder="Nama barang" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white"></div>
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">Qty</label><input type="number" name="items[${itemIndex}][quantity]" value="1" min="1" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white"></div>
        <div class="relative"><label class="block text-xs font-semibold text-gray-500 mb-1">Berat (kg)</label><input type="number" name="items[${itemIndex}][weight]" step="0.01" min="0.01" placeholder="0.5" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white"><button type="button" onclick="this.closest('.item-row').remove()" class="absolute -top-6 right-0 text-red-400 hover:text-red-600 text-xs">Hapus</button></div>
    `;
    container.appendChild(div);
    itemIndex++;
}

function openNewCustomerModal(target) {
    targetSelect = target === 'sender' ? document.getElementById('sender-select') : document.getElementById('receiver-select');
    document.getElementById('customer-modal').classList.remove('hidden');
    document.getElementById('new-name').value = '';
    document.getElementById('new-phone').value = '';
    document.getElementById('new-city').value = '';
    document.getElementById('new-address').value = '';
    document.getElementById('new-email').value = '';
    document.getElementById('modal-error').classList.add('hidden');
}

function closeModal() { document.getElementById('customer-modal').classList.add('hidden'); }

async function saveCustomer() {
    const data = { name: document.getElementById('new-name').value, phone: document.getElementById('new-phone').value, city: document.getElementById('new-city').value, address: document.getElementById('new-address').value, email: document.getElementById('new-email').value };
    const errDiv = document.getElementById('modal-error');
    errDiv.classList.add('hidden');
    try {
        const res = await fetch('{{ route("cashier.customers.quick-store") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }, body: JSON.stringify(data) });
        const json = await res.json();
        if (!res.ok) { errDiv.textContent = Object.values(json.errors || {}).flat().join(', '); errDiv.classList.remove('hidden'); return; }
        const opt = new Option(`${json.name} - ${json.phone}`, json.id, true, true);
        targetSelect.appendChild(opt);
        closeModal();
    } catch(e) { errDiv.textContent = 'Terjadi kesalahan. Coba lagi.'; errDiv.classList.remove('hidden'); }
}

const originSelect = document.getElementById('origin-branch');
const destinationSelect = document.getElementById('destination-branch');
const rateSelect = document.getElementById('rate-select');

function autoSelectRate() {
    const originOption = originSelect?.options[originSelect.selectedIndex];
    const destinationOption = destinationSelect?.options[destinationSelect.selectedIndex];
    
    if (!originOption || !destinationOption) return;
    
    const originCity = originOption.getAttribute('data-city');
    const destinationCity = destinationOption.getAttribute('data-city');
    
    if (!originCity || !destinationCity) {
        if (rateSelect) rateSelect.value = '';
        return;
    }
    
    let found = false;
    if (rateSelect) {
        for (let i = 0; i < rateSelect.options.length; i++) {
            const opt = rateSelect.options[i];
            if (opt.getAttribute('data-origin') === originCity && opt.getAttribute('data-destination') === destinationCity) {
                rateSelect.selectedIndex = i;
                found = true;
                break;
            }
        }
        if (!found) {
            rateSelect.value = '';
        }
    }
}

originSelect?.addEventListener('change', autoSelectRate);
destinationSelect?.addEventListener('change', autoSelectRate);

// Trigger on load
autoSelectRate();
</script>
@endpush
