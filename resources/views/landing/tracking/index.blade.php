@extends('layouts.app')
@section('title', 'Lacak Paket - Trivo')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center py-16 px-4">
    <div class="text-center mb-10">
        <div class="w-16 h-16 bg-[#6abf2e]/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <h1 class="text-3xl font-extrabold text-[#1a2d5a]">Lacak Paket Anda</h1>
        <p class="text-gray-500 mt-2 text-sm">Masukkan nomor resi untuk melihat status pengiriman terkini.</p>
    </div>

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-lg p-8">
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('track') }}" method="POST">
            @csrf
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Resi</label>
            <div class="flex gap-2">
                <input type="text" name="tracking_number" value="{{ request('resi') }}" placeholder="Contoh: KA65A3F2B..." class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none uppercase" style="text-transform: uppercase">
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-5 py-3 rounded-xl text-sm transition-colors">
                    Lacak
                </button>
            </div>
            <p class="text-gray-400 text-xs mt-2">Nomor resi dimulai dengan "KA" dan bisa ditemukan di struk pengiriman Anda.</p>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Status Pengiriman</p>
            <div class="space-y-3">
                @php
                    $statuses = [
                        ['color' => 'yellow', 'label' => 'Menunggu', 'desc' => 'Paket sedang menunggu proses penjemputan'],
                        ['color' => 'blue', 'label' => 'Dijemput', 'desc' => 'Paket sedang dalam proses penjemputan'],
                        ['color' => 'indigo', 'label' => 'Dalam Perjalanan', 'desc' => 'Paket sedang dalam perjalanan'],
                        ['color' => 'orange', 'label' => 'Sedang Diantar', 'desc' => 'Paket sedang diantar ke alamat tujuan'],
                        ['color' => 'green', 'label' => 'Terkirim', 'desc' => 'Paket telah berhasil diterima'],
                    ];
                @endphp
                @foreach($statuses as $s)
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-{{ $s['color'] }}-500 flex-shrink-0"></span>
                    <div>
                        <span class="text-xs font-semibold text-gray-700">{{ $s['label'] }}</span>
                        <span class="text-xs text-gray-400 ml-2">— {{ $s['desc'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
