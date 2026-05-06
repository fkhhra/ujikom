@extends('layouts.dashboard')
@section('title', 'Detail Pengiriman')
@section('page-title', 'Detail Pengiriman')
@section('page-subtitle', $shipment->tracking_number)

@section('content')
<div class="mb-4">
    <a href="{{ route('courier.shipments.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1a2d5a]">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Kembali
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Left: info + timeline --}}
    <div class="lg:col-span-2 space-y-5">
        {{-- Header --}}
        <div class="bg-[#1a2d5a] rounded-xl p-5 text-white">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Nomor Resi</p>
                    <p class="text-xl font-extrabold tracking-wider">{{ $shipment->tracking_number }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $shipment->shipment_date?->format('d M Y') }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $shipment->status_badge }}">{{ $shipment->status_label }}</span>
            </div>
            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-white/10 text-sm">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Pengirim</p>
                    <p class="font-semibold">{{ $shipment->sender?->name }}</p>
                    <p class="text-xs text-gray-400">{{ $shipment->sender?->phone }}</p>
                    <p class="text-xs text-gray-300 mt-0.5">{{ $shipment->sender?->address }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Penerima</p>
                    <p class="font-semibold">{{ $shipment->receiver?->name }}</p>
                    <p class="text-xs text-gray-400">{{ $shipment->receiver?->phone }}</p>
                    <p class="text-xs text-gray-300 mt-0.5">{{ $shipment->receiver?->address }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Asal → Tujuan</p>
                    <p class="font-semibold text-sm">{{ $shipment->originBranch?->city }} → {{ $shipment->destinationBranch?->city }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Pembayaran</p>
                    <p class="font-semibold text-sm">{{ $shipment->payer_type === 'receiver' ? 'COD (Penerima)' : 'Pengirim' }}</p>
                </div>
            </div>
        </div>

        {{-- Items --}}
        @if($shipment->items?->isNotEmpty())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-[#1a2d5a] mb-4">Item Paket</h3>
            <div class="space-y-2">
                @foreach($shipment->items as $item)
                <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                    <div>
                        <p class="text-sm font-medium text-gray-700">{{ $item->name }}</p>
                        <p class="text-xs text-gray-400">{{ $item->quantity }}x · {{ number_format($item->weight,2) }} kg</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between text-sm">
                <span class="font-semibold text-gray-600">Total Berat</span>
                <span class="font-bold text-[#1a2d5a]">{{ number_format($shipment->total_weight,2) }} kg</span>
            </div>
        </div>
        @endif

        {{-- Timeline --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-[#1a2d5a] mb-5">Riwayat Tracking</h3>
            @if($shipment->trackings->isEmpty())
                <p class="text-gray-400 text-sm text-center py-4">Belum ada riwayat</p>
            @else
                <ol class="relative border-l-2 border-gray-100 ml-3">
                    @foreach($shipment->trackings->sortByDesc('tracked_at') as $i => $t)
                    <li class="mb-5 ml-6 last:mb-0">
                        <span class="absolute -left-3.5 flex items-center justify-center w-6 h-6 rounded-full {{ $i === 0 ? 'bg-[#6abf2e]' : 'bg-gray-200' }}">
                            <div class="w-2 h-2 {{ $i === 0 ? 'bg-white' : 'bg-gray-400' }} rounded-full"></div>
                        </span>
                        <div class="{{ $i === 0 ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }} rounded-xl p-4">
                            <div class="flex flex-wrap justify-between gap-1 mb-1">
                                <span class="font-semibold text-sm text-[#1a2d5a]">{{ $t->status_label }}</span>
                                <time class="text-xs text-gray-400">{{ $t->tracked_at?->format('d M Y, H:i') }}</time>
                            </div>
                            <p class="text-sm text-gray-600">{{ $t->description }}</p>
                            @if($t->location)<p class="text-xs text-gray-400 mt-1">📍 {{ $t->location }}</p>@endif
                            @if($t->images?->isNotEmpty())
                                <div class="flex gap-2 mt-2 flex-wrap">
                                    @foreach($t->images as $img)
                                        <img src="{{ Storage::url($img->image_path) }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200 cursor-pointer" onclick="this.requestFullscreen()">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ol>
            @endif
        </div>
    </div>

    {{-- Right: update status --}}
    <div>
        @if($statusOptions->isNotEmpty())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-[#1a2d5a] mb-5">Update Status</h3>
            <form action="{{ route('courier.shipments.update-status', $shipment) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status Baru</label>
                    <select name="status" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white @error('status') border-red-400 @enderror">
                        <option value="">Pilih status</option>
                        @foreach($statusOptions as $opt)
                            <option value="{{ $opt['value'] }}" {{ old('status')===$opt['value'] ? 'selected' : '' }}>{{ $opt['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Lokasi</label>
                    <select name="location_id" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white @error('location_id') border-red-400 @enderror">
                        <option value="">Pilih lokasi</option>
                        @foreach($branches as $b)
                            <option value="{{ $b->id }}" {{ old('location_id', $defaultLocationId)==$b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                    <textarea name="description" rows="3" placeholder="Contoh: Paket telah dijemput dari pengirim" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none resize-none @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Bukti <span class="text-gray-400 font-normal">(opsional, maks 5)</span></label>
                    <input type="file" name="images[]" multiple accept="image/*" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#6abf2e]/10 file:text-[#6abf2e]">
                </div>
                <button type="submit" class="w-full bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-bold py-3 rounded-xl transition-colors">
                    Perbarui Status
                </button>
            </form>
        </div>
        @else
            @if($shipment->status === 'delivered')
            <div class="bg-green-50 border border-green-200 rounded-xl p-5 text-center">
                <svg class="w-10 h-10 text-green-500 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="font-bold text-green-700">Pengiriman Selesai</p>
                <p class="text-xs text-green-600 mt-1">Paket telah diterima penerima</p>
            </div>
            @else
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 text-center text-gray-400">
                <p class="text-sm">Tidak ada transisi status yang tersedia.</p>
            </div>
            @endif
        @endif

        {{-- COD notice --}}
        @if($shipment->payer_type === 'receiver' && $shipment->status !== 'delivered')
        <div class="mt-4 bg-orange-50 border border-orange-200 rounded-xl p-4">
            <div class="flex items-start gap-2">
                <svg class="w-4 h-4 text-orange-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <div>
                    <p class="text-xs font-semibold text-orange-700">COD – Tagih Saat Delivery</p>
                    <p class="text-xs text-orange-600 mt-0.5">Tagih Rp {{ number_format($shipment->total_price,0,',','.') }} saat menyerahkan paket ke penerima.</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
