@extends('layouts.dashboard')
@section('title', 'Detail Pengiriman')
@section('page-title', 'Detail Pengiriman')
@section('page-subtitle', $shipment->tracking_number)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.shipments.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1a2d5a]">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">
        {{-- Shipment info --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <div>
                    <h3 class="font-bold text-[#1a2d5a] text-lg">{{ $shipment->tracking_number }}</h3>
                    <p class="text-gray-400 text-xs">{{ $shipment->shipment_date?->format('d M Y') }}</p>
                </div>
                <div class="flex gap-2 flex-wrap">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $shipment->status_badge }}">{{ $shipment->status_label }}</span>
                    @if($shipment->payment)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $shipment->payment->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $shipment->payment->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Pengirim</p>
                    <p class="font-semibold text-gray-700">{{ $shipment->sender?->name ?? '-' }}</p>
                    <p class="text-xs text-gray-400">{{ $shipment->sender?->phone }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Penerima</p>
                    <p class="font-semibold text-gray-700">{{ $shipment->receiver?->name ?? '-' }}</p>
                    <p class="text-xs text-gray-400">{{ $shipment->receiver?->phone }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Cabang Asal</p>
                    <p class="font-semibold text-gray-700">{{ $shipment->originBranch?->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Cabang Tujuan</p>
                    <p class="font-semibold text-gray-700">{{ $shipment->destinationBranch?->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Berat Total</p>
                    <p class="font-semibold text-gray-700">{{ number_format($shipment->total_weight, 2) }} kg</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Total Biaya</p>
                    <p class="font-bold text-[#6abf2e]">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Pembayaran</p>
                    <p class="font-semibold text-gray-700">{{ $shipment->isCod() ? 'COD' : 'Dibayar Pengirim' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Kurir</p>
                    <p class="font-semibold text-gray-700">{{ $shipment->courier?->name ?? 'Belum ditugaskan' }}</p>
                </div>
            </div>
        </div>

        {{-- Items --}}
        @if($shipment->items->isNotEmpty())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-[#1a2d5a] mb-4">Item Paket</h3>
            <table class="w-full text-sm">
                <thead class="bg-gray-50"><tr>
                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-gray-500">Nama</th>
                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-gray-500">Qty</th>
                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-gray-500">Berat</th>
                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-gray-500">Catatan</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($shipment->items as $item)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-700">{{ $item->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $item->quantity }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ number_format($item->weight, 2) }} kg</td>
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $item->description ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- Timeline --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-[#1a2d5a] mb-5">Riwayat Tracking</h3>
            @if($shipment->trackings->isEmpty())
                <p class="text-gray-400 text-sm text-center py-4">Belum ada tracking</p>
            @else
                <ol class="relative border-l-2 border-gray-100 ml-3">
                    @foreach($shipment->trackings->reverse() as $i => $t)
                    <li class="mb-5 ml-6 last:mb-0">
                        <span class="absolute -left-3.5 flex items-center justify-center w-6 h-6 rounded-full {{ $i === 0 ? 'bg-[#6abf2e]' : 'bg-gray-200' }}">
                            <div class="w-2 h-2 {{ $i === 0 ? 'bg-white' : 'bg-gray-400' }} rounded-full"></div>
                        </span>
                        <div class="{{ $i === 0 ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }} rounded-xl p-4">
                            <div class="flex justify-between mb-1">
                                <span class="font-semibold text-sm text-[#1a2d5a]">{{ $t->status_label }}</span>
                                <time class="text-xs text-gray-400">{{ $t->tracked_at?->format('d M Y, H:i') }}</time>
                            </div>
                            <p class="text-sm text-gray-600">{{ $t->description }}</p>
                            @if($t->location) <p class="text-xs text-gray-400 mt-1">📍 {{ $t->location }}</p> @endif
                        </div>
                    </li>
                    @endforeach
                </ol>
            @endif
        </div>
    </div>

    {{-- Sidebar actions --}}
    <div class="space-y-5">
        {{-- Assign courier --}}
        @if(in_array($shipment->status, ['pending', 'arrived_at_branch']))
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-[#1a2d5a] mb-4">Tugaskan Kurir</h3>
            <form action="{{ route('admin.shipments.assign-courier', $shipment) }}" method="POST" class="space-y-3">
                @csrf
                <select name="courier_id" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none bg-white">
                    <option value="">Pilih kurir</option>
                    @foreach($couriers as $c)
                        <option value="{{ $c->id }}" {{ $shipment->courier_id == $c->id ? 'selected' : '' }}>
                            {{ $c->name }} {{ $c->vehicle ? '('.$c->vehicle->license_plate.')' : '' }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="w-full bg-[#1a2d5a] hover:bg-[#162250] text-white text-sm font-semibold py-2.5 rounded-xl transition-colors">
                    Tugaskan
                </button>
            </form>
        </div>
        @endif

        {{-- Print waybill if payment --}}
        @if($shipment->payment)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-[#1a2d5a] mb-4">Dokumen</h3>
            <a href="{{ route('admin.payments.print-receipt', $shipment->payment) }}" target="_blank" class="block w-full text-center bg-[#6abf2e] hover:bg-[#5aaa25] text-white text-sm font-semibold py-2.5 rounded-xl transition-colors">
                Cetak Bukti Bayar
            </a>
        </div>
        @endif

        {{-- Cancel --}}
        @if(!in_array($shipment->status, ['delivered', 'cancelled']))
        <div class="bg-white rounded-xl border border-red-100 shadow-sm p-5">
            <h3 class="font-bold text-red-600 mb-3">Batalkan Pengiriman</h3>
            <p class="text-xs text-gray-500 mb-3">Tindakan ini tidak dapat dibatalkan.</p>
            <form action="{{ route('admin.shipments.cancel', $shipment) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pengiriman ini?')">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors">
                    Batalkan
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
