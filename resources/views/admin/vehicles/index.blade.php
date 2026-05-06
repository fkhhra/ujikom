@extends('layouts.dashboard')
@section('title', 'Kendaraan')
@section('page-title', 'Manajemen Kendaraan')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.vehicles.create') }}" class="inline-flex items-center gap-2 bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Kendaraan
    </a>
</div>
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="p-4 border-b border-gray-50">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-48 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari plat nomor..." class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
            </div>
            <select name="type" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                <option value="">Semua Tipe</option>
                <option value="motor" {{ request('type')==='motor' ? 'selected' : '' }}>Motor</option>
                <option value="mobil" {{ request('type')==='mobil' ? 'selected' : '' }}>Mobil</option>
                <option value="truck" {{ request('type')==='truck' ? 'selected' : '' }}>Truck</option>
            </select>
            <button type="submit" class="bg-[#1a2d5a] text-white text-sm font-semibold px-5 py-2 rounded-lg">Filter</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Plat Nomor</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipe</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Kepemilikan</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Cabang</th>
                <th class="px-5 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($vehicles as $v)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3.5 font-mono font-semibold text-[#1a2d5a]">{{ $v->plate_number }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $v->type === 'motor' ? 'bg-blue-100 text-blue-700' : ($v->type === 'truck' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-700') }} capitalize">{{ $v->type }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-500 capitalize hidden sm:table-cell">{{ $v->ownership }}</td>
                    <td class="px-5 py-3.5 text-gray-500 hidden md:table-cell">{{ $v->branch?->name ?? '-' }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex gap-3">
                            <a href="{{ route('admin.vehicles.edit', $v) }}" class="text-[#6abf2e] text-xs font-semibold hover:underline">Edit</a>
                            <form action="{{ route('admin.vehicles.destroy', $v) }}" method="POST" onsubmit="return confirm('Hapus kendaraan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 text-xs font-semibold hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">Belum ada kendaraan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($vehicles->hasPages())<div class="p-4 border-t border-gray-50">{{ $vehicles->links() }}</div>@endif
</div>
@endsection
