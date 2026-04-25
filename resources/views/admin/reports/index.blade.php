@extends('layouts.dashboard')
@section('title', 'Laporan - Trivo Admin')
@section('sidebar')
@include('components.admin-sidebar')
@endsection
@section('main-content')
<div class="mb-6">
    <h1 class="text-2xl font-extrabold text-[#1a2b5c]">Laporan Pengiriman</h1>
    <p class="text-gray-500 text-sm">Unduh laporan dalam format PDF</p>
</div>

<div class="max-w-xl">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <form method="GET" action="{{ route('admin.reports.generate') }}" target="_blank" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Mulai</label>
                    <input type="text" name="start_date" value="{{ old('start_date') }}" required
                        placeholder="dd-mm-yyyy"
                        class="w-full border @error('start_date') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none"
                        id="start_date">
                    @error('start_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Selesai</label>
                    <input type="text" name="end_date" value="{{ old('end_date') }}" required
                        placeholder="dd-mm-yyyy"
                        class="w-full border @error('end_date') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none"
                        id="end_date">
                    @error('end_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status (Opsional)</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                    <option value="">Semua Status</option>
                    @foreach(['pending'=>'Menunggu','picked_up'=>'Diambil','in_transit'=>'Dalam Perjalanan','arrived_at_branch'=>'Di Cabang','out_for_delivery'=>'Sedang Diantar','delivered'=>'Terkirim','cancelled'=>'Dibatalkan'] as $val => $label)
                    <option value="{{ $val }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="w-full bg-[#1a2b5c] hover:bg-[#111e42] text-white font-semibold py-3 rounded-lg text-sm transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Unduh Laporan PDF
            </button>
        </form>
    </div>
</div>
@endsection
