@extends('layouts.dashboard')
@section('title', 'Detail Pengiriman - Trivo Admin')

@section('sidebar')
@include('components.admin-sidebar')
@endsection

@section('main-content')
<div class="mb-5">
    <a href="{{ route('admin.shipments.index') }}" class="text-sm text-gray-500 hover:text-[#1a2b5c] transition-colors">← Kembali</a>
    <h1 class="text-2xl font-extrabold text-[#1a2b5c] mt-1">Detail Pengiriman</h1>
    <p class="text-gray-500 text-sm font-mono">{{ $shipment->tracking_number }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2 space-y-5">

        {{-- STATUS & ACTIONS --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Status Pengiriman</p>
                    <x-status-badge :status="$shipment->status"/>
                </div>
                <div class="flex gap-2 flex-wrap">
                    @if($shipment->status !== 'cancelled' && $shipment->status !== 'delivered')
                    <form method="POST" action="{{ route('admin.shipments.cancel', $shipment) }}"
                        onsubmit="return confirm('Yakin ingin membatalkan pengiriman ini?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-4 py-2 rounded-lg text-xs transition-all border border-red-200">
                            Batalkan
                        </button>
                    </form>
                    @endif
                    @if($shipment->payment)
                    <a href="{{ route('admin.payments.print', $shipment->payment) }}" target="_blank"
                        class="bg-[#1a2b5c] hover:bg-[#111e42] text-white font-semibold px-4 py-2 rounded-lg text-xs transition-all">
                        Cetak Kwitansi
                    </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- ASSIGN KURIR --}}
        @if(in_array($shipment->status, ['pending', 'arrived_at_branch']))
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-4">Tugaskan Kurir</h3>
            <form method="POST" action="{{ route('admin.shipments.assign-courier', $shipment) }}" class="flex gap-3 flex-wrap">
                @csrf
                <select name="courier_id" required class="flex-1 min-w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                    <option value="">Pilih kurir...</option>
                    @foreach($couriers as $courier)
                    <option value="{{ $courier->id }}" {{ $shipment->courier_id == $courier->id ? 'selected' : '' }}>
                        {{ $courier->name }} {{ $courier->vehicle ? '— '.$courier->vehicle->plate_number : '' }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-4 py-2 rounded-lg text-sm transition-all">
                    Tugaskan
                </button>
            </form>
        </div>
        @elseif($shipment->courier)
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-2">Kurir Bertugas</h3>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#1a2b5c] rounded-full flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr($shipment->courier->name, 0, 2)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ $shipment->courier->name }}</p>
                    <p class="text-xs text-gray-500">{{ $shipment->courier->email }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- SENDER & RECEIVER --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-[#1a2b5c] text-sm mb-3">Pengirim</h3>
                <p class="font-semibold text-gray-800">{{ $shipment->sender?->name ?? '-' }}</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ $shipment->sender?->phone ?? '' }}</p>
                <p class="text-sm text-gray-500">{{ $shipment->sender?->email ?? '' }}</p>
                <div class="mt-2 pt-2 border-t border-gray-100">
                    <p class="text-xs font-semibold text-gray-500">Cabang Asal</p>
                    <p class="text-sm text-gray-700">{{ $shipment->originBranch?->name }}</p>
                    <p class="text-xs text-gray-500">{{ $shipment->originBranch?->city }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-[#1a2b5c] text-sm mb-3">Penerima</h3>
                <p class="font-semibold text-gray-800">{{ $shipment->receiver?->name ?? '-' }}</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ $shipment->receiver?->phone ?? '' }}</p>
                <p class="text-sm text-gray-500">{{ $shipment->receiver?->email ?? '' }}</p>
                <div class="mt-2 pt-2 border-t border-gray-100">
                    <p class="text-xs font-semibold text-gray-500">Cabang Tujuan</p>
                    <p class="text-sm text-gray-700">{{ $shipment->destinationBranch?->name }}</p>
                    <p class="text-xs text-gray-500">{{ $shipment->destinationBranch?->city }}</p>
                </div>
            </div>
        </div>

        {{-- ITEMS --}}
        @if($shipment->items->count())
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-4">Item Paket</h3>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-3 py-2 text-left">Nama Item</th>
                        <th class="px-3 py-2 text-center">Qty</th>
                        <th class="px-3 py-2 text-right">Berat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($shipment->items as $item)
                    <tr>
                        <td class="px-3 py-2 text-gray-700">{{ $item->name }}</td>
                        <td class="px-3 py-2 text-center text-gray-600">{{ $item->quantity }}</td>
                        <td class="px-3 py-2 text-right text-gray-600">{{ $item->weight }} kg</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- TRACKING HISTORY --}}
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
                            <time class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($track->tracked_at)->isoFormat('D MMM Y, HH:mm') }}</time>
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
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-4">Ringkasan Biaya</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Total Berat</span>
                    <span class="font-semibold">{{ $shipment->total_weight }} kg</span>
                </div>
                @if($shipment->rate)
                <div class="flex justify-between">
                    <span class="text-gray-500">Tarif / kg</span>
                    <span class="font-semibold">Rp {{ number_format($shipment->rate->price_per_kg, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Estimasi</span>
                    <span class="font-semibold">{{ $shipment->rate->estimated_days }} hari</span>
                </div>
                @endif
                <div class="border-t border-gray-100 pt-2 flex justify-between">
                    <span class="font-semibold text-gray-700">Total Biaya</span>
                    <span class="font-bold text-[#6abf2e]">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Pembayar</span>
                    <span class="font-semibold capitalize">{{ $shipment->payer_type }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status Bayar</span>
                    <x-status-badge :status="$shipment->payment?->payment_status ?? 'unpaid'"/>
                </div>
            </div>
        </div>
        @if($shipment->shipment_date)
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <h3 class="font-bold text-[#1a2b5c] text-sm mb-2">Tanggal Kirim</h3>
            <p class="text-gray-700 font-semibold">{{ \Carbon\Carbon::parse($shipment->shipment_date)->isoFormat('D MMMM Y') }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
