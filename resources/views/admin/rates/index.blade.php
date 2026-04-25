@extends('layouts.dashboard')
@section('title', 'Tarif - Trivo Admin')
@section('sidebar')
@include('components.admin-sidebar')
@endsection
@section('main-content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-[#1a2b5c]">Tarif Pengiriman</h1>
        <p class="text-gray-500 text-sm">Kelola daftar tarif antar kota</p>
    </div>
    <a href="{{ route('admin.rates.create') }}" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-4 py-2 rounded-lg text-sm transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Tarif
    </a>
</div>

<div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Kota Asal</label>
            <select name="origin_city" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                <option value="">Semua</option>
                @foreach($cities as $city)
                <option value="{{ $city }}" {{ request('origin_city')==$city?'selected':'' }}>{{ $city }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Kota Tujuan</label>
            <select name="destination_city" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                <option value="">Semua</option>
                @foreach($cities as $city)
                <option value="{{ $city }}" {{ request('destination_city')==$city?'selected':'' }}>{{ $city }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-[#1a2b5c] hover:bg-[#111e42] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all">Filter</button>
        @if(request()->anyFilled(['origin_city','destination_city']))
        <a href="{{ route('admin.rates.index') }}" class="text-sm text-gray-500 hover:text-red-500 py-2">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-5 py-3 text-left">Kota Asal</th>
                    <th class="px-5 py-3 text-left">Kota Tujuan</th>
                    <th class="px-5 py-3 text-left">Tarif / kg</th>
                    <th class="px-5 py-3 text-left">Estimasi</th>
                    <th class="px-5 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($rates as $rate)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3 font-semibold text-gray-800">{{ $rate->origin_city }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $rate->destination_city }}</td>
                    <td class="px-5 py-3 text-[#6abf2e] font-semibold">Rp {{ number_format($rate->price_per_kg, 0, ',', '.') }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $rate->estimated_days }} hari</td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.rates.edit', $rate) }}" class="text-[#1a2b5c] hover:text-[#6abf2e] font-semibold text-xs transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.rates.destroy', $rate) }}" onsubmit="return confirm('Hapus tarif ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-12 text-gray-400 text-sm">Belum ada tarif</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($rates->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $rates->links() }}</div>
    @endif
</div>
@endsection
