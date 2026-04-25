@extends('layouts.dashboard')
@section('title', 'Detail Pengiriman - Kurir Trivo')
@section('sidebar')
@include('components.courier-sidebar')
@endsection
@section('main-content')
<div class="mb-5">
    <a href="{{ route('courier.shipments.index') }}" class="text-sm text-gray-500 hover:text-[#1a2b5c] transition-colors">← Kembali</a>
    <h1 class="text-2xl font-extrabold text-[#1a2b5c] mt-1">Detail Pengiriman</h1>
    <p class="text-gray-500 text-sm font-mono">{{ $shipment->tracking_number }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2 space-y-5">

        {{-- STATUS & UPDATE --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Status Saat Ini</p>
                    <x-status-badge :status="$shipment->status"/>
                </div>
            </div>

            @php
            $nextStatuses = [
                'pending'           => ['picked_up'         => 'Tandai Sudah Diambil'],
                'picked_up'         => ['in_transit'        => 'Tandai Dalam Perjalanan'],
                'in_transit'        => ['arrived_at_branch' => 'Tiba di Cabang Tujuan'],
                'arrived_at_branch' => ['out_for_delivery'  => 'Mulai Antar ke Penerima'],
                'out_for_delivery'  => ['delivered'         => 'Tandai Terkirim'],
            ];
            $available = $nextStatuses[$shipment->status] ?? [];
            @endphp

            @if(!empty($available))
            <form method="POST" action="{{ route('courier.shipments.update-status', $shipment) }}"
                enctype="multipart/form-data" id="update-form" class="space-y-4 border-t border-gray-100 pt-4">
                @csrf @method('PATCH')
                <input type="hidden" name="status" id="new-status" value="{{ array_key_first($available) }}">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Lokasi Saat Ini</label>
                    <input type="text" name="location" required placeholder="Nama kota / lokasi..."
                        class="w-full border @error('location') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                    @error('location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                    <textarea name="description" rows="2" placeholder="Keterangan status pengiriman..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none resize-none">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Bukti (Opsional)</label>
                    <input type="file" name="images[]" accept="image/*" multiple
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                    <p class="text-xs text-gray-400 mt-1">Bisa upload beberapa foto sekaligus</p>
                </div>
                <div class="flex gap-2 flex-wrap">
                    @foreach($available as $statusVal => $statusLabel)
                    <button type="submit" onclick="document.getElementById('new-status').value='{{ $statusVal }}'"
                        class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ $statusLabel }}
                    </button>
                    @endforeach
                </div>
            </form>
            @else
            <div class="border-t border-gray-100 pt-4">
                <p class="text-sm text-gray-500">
                    @if($shipment->status === 'delivered')
                    ✅ Pengiriman telah selesai.
                    @elseif($shipment->status === 'cancelled')
                    ❌ Pengiriman telah dibatalkan.
                    @else
                    Tidak ada aksi yang tersedia.
                    @endif
                </p>
            </div>
            @endif
        </div>

        {{-- PENGIRIM & PENERIMA --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-[#1a2b5c] text-sm mb-3">Pengirim</h3>
                <p class="font-semibold text-gray-800">{{ $shipment->sender?->name }}</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ $shipment->sender?->phone }}</p>
                <p class="text-xs text-gray-400 mt-2 border-t border-gray-100 pt-2">
                    <span class="font-semibold">Cabang Asal:</span><br>
                    {{ $shipment->originBranch?->name }}<br>
                    {{ $shipment->originBranch?->address }}
                </p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-[#1a2b5c] text-sm mb-3">Penerima</h3>
                <p class="font-semibold text-gray-800">{{ $shipment->receiver?->name }}</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ $shipment->receiver?->phone }}</p>
                <p class="text-xs text-gray-400 mt-2 border-t border-gray-100 pt-2">
                    <span class="font-semibold">Alamat:</span><br>
                    {{ $shipment->receiver?->address }}, {{ $shipment->receiver?->city }}
                </p>
            </div>
        </div>

        {{-- TIMELINE --}}
        @if($shipment->trackings->count())
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-5">Riwayat Perjalanan</h3>
            <ol class="relative border-s border-[#6abf2e]/30 ms-3">
                @foreach($shipment->trackings->sortByDesc('tracked_at') as $track)
                <li class="mb-5 ms-6">
                    <span class="absolute flex items-center justify-center w-7 h-7 bg-[#6abf2e] rounded-full -start-3.5 ring-4 ring-white">
                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </span>
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                            <span class="text-sm font-semibold text-[#1a2b5c]">{{ $track->location }}</span>
                            <time class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($track->tracked_at)->isoFormat('D MMM, HH:mm') }}</time>
                        </div>
                        <p class="text-xs text-gray-600">{{ $track->description }}</p>
                        @if($track->images && $track->images->count())
                        <div class="flex gap-2 mt-2 flex-wrap">
                            @foreach($track->images as $img)
                            <a href="{{ Storage::url($img->image_path) }}" target="_blank">
                                <img src="{{ Storage::url($img->image_path) }}" class="w-16 h-16 rounded-lg object-cover border border-gray-200 hover:opacity-80 transition-opacity">
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
        @endif
    </div>

    {{-- SIDEBAR --}}
    <div class="space-y-4">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-4">Info Paket</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Total Berat</span>
                    <span class="font-semibold">{{ $shipment->total_weight }} kg</span>
                </div>
                @if($shipment->items->count())
                <div class="border-t border-gray-100 pt-2">
                    <p class="text-xs font-semibold text-gray-500 mb-2">Item:</p>
                    @foreach($shipment->items as $item)
                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                        <span>{{ $item->name }}</span>
                        <span>{{ $item->weight }} kg</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        @if($shipment->vehicle)
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-3">Kendaraan</h3>
            <p class="font-mono font-bold text-gray-800">{{ $shipment->vehicle?->plate_number }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $shipment->vehicle?->brand }} {{ $shipment->vehicle?->model }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
