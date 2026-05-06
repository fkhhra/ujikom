@extends('layouts.dashboard')
@section('title', 'Laporan')
@section('page-title', 'Laporan Pengiriman')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-[#6abf2e]/10 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-[#1a2d5a]">Generate Laporan PDF</h3>
                <p class="text-xs text-gray-400">Ekspor data pengiriman berdasarkan rentang tanggal</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
            </div>
        @endif

        <form action="{{ route('admin.reports.generate') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Mulai</label>
                    <input type="text" name="start_date" placeholder="DD-MM-YYYY" value="{{ request('start_date') }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Selesai</label>
                    <input type="text" name="end_date" placeholder="DD-MM-YYYY" value="{{ request('end_date') }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Filter Status (Opsional)</label>
                <select name="status" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                    <option value="">Semua Status</option>
                    @foreach(['pending'=>'Menunggu','picked_up'=>'Dijemput','in_transit'=>'Dalam Perjalanan','arrived_at_branch'=>'Tiba di Cabang','out_for_delivery'=>'Sedang Diantar','delivered'=>'Terkirim','cancelled'=>'Dibatalkan'] as $v => $l)
                        <option value="{{ $v }}" {{ request('status')===$v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="w-full bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Unduh Laporan PDF
            </button>
        </form>
    </div>
</div>
@endsection
