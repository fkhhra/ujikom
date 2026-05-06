@extends('layouts.dashboard')
@section('title', 'Tarif')
@section('page-title', 'Manajemen Tarif')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.rates.create') }}" class="inline-flex items-center gap-2 bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Tarif
    </a>
</div>
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="p-4 border-b border-gray-50">
        <form method="GET" class="flex flex-wrap gap-3">
            <select name="origin_city" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                <option value="">Semua Asal</option>
                @foreach($cities as $c)<option value="{{ $c }}" {{ request('origin_city')===$c ? 'selected' : '' }}>{{ $c }}</option>@endforeach
            </select>
            <select name="destination_city" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                <option value="">Semua Tujuan</option>
                @foreach($cities as $c)<option value="{{ $c }}" {{ request('destination_city')===$c ? 'selected' : '' }}>{{ $c }}</option>@endforeach
            </select>
            <button type="submit" class="bg-[#1a2d5a] text-white text-sm font-semibold px-5 py-2 rounded-lg">Filter</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Asal</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tujuan</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Harga/kg</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Est. Hari</th>
                <th class="px-5 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($rates as $r)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3.5 font-medium text-gray-700">{{ $r->origin_city }}</td>
                    <td class="px-5 py-3.5 font-medium text-gray-700">{{ $r->destination_city }}</td>
                    <td class="px-5 py-3.5 font-semibold text-[#6abf2e]">Rp {{ number_format($r->price_per_kg, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5 text-gray-500 hidden sm:table-cell">{{ $r->estimated_days }} hari</td>
                    <td class="px-5 py-3.5">
                        <div class="flex gap-3">
                            <a href="{{ route('admin.rates.edit', $r) }}" class="text-[#6abf2e] text-xs font-semibold hover:underline">Edit</a>
                            <form action="{{ route('admin.rates.destroy', $r) }}" method="POST" onsubmit="return confirm('Hapus tarif ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 text-xs font-semibold hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">Belum ada tarif</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($rates->hasPages())<div class="p-4 border-t border-gray-50">{{ $rates->links() }}</div>@endif
</div>
@endsection
