@extends('layouts.dashboard')
@section('title', 'Kendaraan - Trivo Admin')
@section('sidebar')
@include('components.admin-sidebar')
@endsection
@section('main-content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-[#1a2b5c]">Kendaraan</h1>
        <p class="text-gray-500 text-sm">Kelola armada kendaraan operasional</p>
    </div>
    <a href="{{ route('admin.vehicles.create') }}" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-4 py-2 rounded-lg text-sm transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Kendaraan
    </a>
</div>

<div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Cari Plat</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="B 1234 XYZ"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Tipe</label>
            <select name="type" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                <option value="">Semua Tipe</option>
                <option value="motor" {{ request('type')=='motor'?'selected':'' }}>Motor</option>
                <option value="mobil" {{ request('type')=='mobil'?'selected':'' }}>Mobil</option>
                <option value="truck" {{ request('type')=='truck'?'selected':'' }}>Truck</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Kepemilikan</label>
            <select name="ownership" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                <option value="">Semua</option>
                <option value="company" {{ request('ownership')=='company'?'selected':'' }}>Perusahaan</option>
                <option value="personal" {{ request('ownership')=='personal'?'selected':'' }}>Pribadi</option>
            </select>
        </div>
        <button type="submit" class="bg-[#1a2b5c] hover:bg-[#111e42] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all">Filter</button>
        @if(request()->anyFilled(['search','type','ownership']))
        <a href="{{ route('admin.vehicles.index') }}" class="text-sm text-gray-500 hover:text-red-500 py-2">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-5 py-3 text-left">Plat Nomor</th>
                    <th class="px-5 py-3 text-left">Tipe</th>
                    <th class="px-5 py-3 text-left">Merek/Model</th>
                    <th class="px-5 py-3 text-left">Kepemilikan</th>
                    <th class="px-5 py-3 text-left">Cabang</th>
                    <th class="px-5 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($vehicles as $vehicle)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3 font-mono font-semibold text-[#1a2b5c]">{{ $vehicle->plate_number }}</td>
                    <td class="px-5 py-3 capitalize text-gray-700">{{ $vehicle->type }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $vehicle->ownership=='company' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }} capitalize">
                            {{ $vehicle->ownership == 'company' ? 'Perusahaan' : 'Pribadi' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $vehicle->branch?->name ?? '-' }}</td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="text-[#1a2b5c] hover:text-[#6abf2e] font-semibold text-xs">Edit</a>
                            <form method="POST" action="{{ route('admin.vehicles.destroy', $vehicle) }}" onsubmit="return confirm('Hapus kendaraan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-400 text-sm">Belum ada kendaraan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($vehicles->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $vehicles->links() }}</div>
    @endif
</div>
@endsection
