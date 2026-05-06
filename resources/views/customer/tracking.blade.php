@extends('layouts.customer')
@section('title', 'Lacak Paket ' . $shipment->tracking_number)

@section('content')
<div class="mb-5">
    <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1a2d5a]">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Dashboard
    </a>
</div>

{{-- Hero card --}}
<div class="bg-[#1a2d5a] rounded-2xl p-6 text-white mb-6 shadow-lg">
    <div class="flex flex-wrap items-start justify-between gap-4 mb-5">
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold mb-1">Nomor Resi</p>
            <p class="text-2xl font-extrabold tracking-wider">{{ $shipment->tracking_number }}</p>
            <p class="text-sm text-gray-400 mt-1">{{ $shipment->shipment_date?->format('d M Y') }}</p>
        </div>
        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $shipment->status_badge }}">{{ $shipment->status_label }}</span>
    </div>

    {{-- Progress bar --}}
    @php
        $steps = ['pending','picked_up','in_transit','arrived_at_branch','out_for_delivery','delivered'];
        $currentIdx = array_search($shipment->status, $steps);
        if($currentIdx === false) $currentIdx = 0;
        $progress = $currentIdx === 0 ? 0 : round(($currentIdx / (count($steps)-1)) * 100);
    @endphp
    <div class="mb-5">
        <div class="flex justify-between text-xs text-gray-400 mb-1.5">
            <span>Menunggu</span>
            <span>Dalam Perjalanan</span>
            <span>Terkirim</span>
        </div>
        <div class="h-2 bg-white/10 rounded-full overflow-hidden">
            <div class="h-full bg-[#6abf2e] rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm pt-4 border-t border-white/10">
        <div><p class="text-xs text-gray-400 mb-0.5">Pengirim</p><p class="font-semibold">{{ $shipment->sender?->name }}</p></div>
        <div><p class="text-xs text-gray-400 mb-0.5">Penerima</p><p class="font-semibold">{{ $shipment->receiver?->name }}</p></div>
        <div><p class="text-xs text-gray-400 mb-0.5">Dari</p><p class="font-semibold">{{ $shipment->originBranch?->city }}</p></div>
        <div><p class="text-xs text-gray-400 mb-0.5">Tujuan</p><p class="font-semibold">{{ $shipment->destinationBranch?->city }}</p></div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-5">
    {{-- Timeline --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-[#1a2d5a] mb-6">Riwayat Pengiriman</h3>
        @if($shipment->trackings->isEmpty())
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="text-gray-400 text-sm">Belum ada pembaruan status</p>
            </div>
        @else
            <ol class="relative border-l-2 border-gray-100 ml-3">
                @foreach($shipment->trackings->sortByDesc('tracked_at') as $i => $t)
                <li class="mb-6 ml-6 last:mb-0">
                    <span class="absolute -left-3.5 flex items-center justify-center w-6 h-6 rounded-full {{ $i === 0 ? 'bg-[#6abf2e]' : 'bg-gray-200' }}">
                        @if($i === 0)
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @else
                            <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                        @endif
                    </span>
                    <div class="{{ $i === 0 ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-100' }} rounded-xl p-4">
                        <div class="flex flex-wrap justify-between gap-1 mb-1">
                            <span class="font-semibold text-sm text-[#1a2d5a]">{{ $t->status_label }}</span>
                            <time class="text-xs text-gray-400">{{ $t->tracked_at?->format('d M Y, H:i') }}</time>
                        </div>
                        <p class="text-sm text-gray-600">{{ $t->description }}</p>
                        @if($t->location)<p class="text-xs text-gray-400 mt-1 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg> {{ $t->location }}</p>@endif
                        @if($t->images?->isNotEmpty())
                            <div class="flex gap-2 mt-2 flex-wrap">
                                @foreach($t->images as $img)
                                    <img src="{{ Storage::url($img->image_path) }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </li>
                @endforeach
            </ol>
        @endif
    </div>

    {{-- Detail + Payment --}}
    <div class="space-y-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-[#1a2d5a] mb-4">Detail Paket</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Total Berat</span><span class="font-semibold">{{ number_format($shipment->total_weight,2) }} kg</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Total Biaya</span><span class="font-bold text-[#6abf2e]">Rp {{ number_format($shipment->total_price,0,',','.') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Pembayaran</span><span class="font-medium">{{ $shipment->payer_type === 'receiver' ? 'COD' : 'Pengirim' }}</span></div>
            </div>
        </div>

        {{-- Payment action --}}
        @if($shipment->payer_type === 'sender' && auth('customer')->id() === $shipment->sender_id)
            @if($shipment->payment && $shipment->payment->payment_status === 'paid')
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <div><p class="font-semibold text-green-700 text-sm">Pembayaran Lunas</p><p class="text-xs text-green-600">Terima kasih!</p></div>
                </div>
            @elseif($shipment->payment && $shipment->payment->payment_status === 'pending')
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="font-bold text-[#1a2d5a] mb-3">Selesaikan Pembayaran</h3>
                    <p class="text-sm text-gray-500 mb-3">Pembayaran Anda belum selesai.</p>
                    <a href="{{ route('customer.payments.checkout', $shipment->payment) }}" class="block w-full text-center bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">
                        Lanjutkan Pembayaran
                    </a>
                </div>
            @else
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="font-bold text-[#1a2d5a] mb-3">Bayar Sekarang</h3>
                    <p class="text-sm text-gray-500 mb-4">Total: <span class="font-bold text-[#1a2d5a]">Rp {{ number_format($shipment->total_price,0,',','.') }}</span></p>
                    <form action="{{ route('customer.payments.pay', $shipment) }}" method="POST" class="space-y-3">
                        @csrf
                        <select name="payment_method" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                            <option value="qris">QRIS</option>
                            <option value="gopay">GoPay</option>
                            <option value="bca">Transfer BCA</option>
                            <option value="bri">Transfer BRI</option>
                            <option value="bni">Transfer BNI</option>
                            <option value="bsi">Transfer BSI</option>
                            <option value="mandiri">Mandiri Echannel</option>
                        </select>
                        <button type="submit" class="w-full bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-bold py-2.5 rounded-xl text-sm transition-colors">Bayar</button>
                    </form>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
