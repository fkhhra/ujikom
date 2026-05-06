@extends('layouts.dashboard')
@section('title', 'Edit Kendaraan')
@section('page-title', 'Edit Kendaraan')

@section('content')
<div class="max-w-lg">
    <a href="{{ route('admin.vehicles.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1a2d5a] mb-5">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Kembali
    </a>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.vehicles.update', $vehicle) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Plat Nomor</label>
                <input type="text" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none" style="text-transform:uppercase">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe</label>
                    <select name="type" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                        @foreach(['motor','mobil','truck'] as $t)
                            <option value="{{ $t }}" {{ old('type', $vehicle->type)===$t ? 'selected' : '' }} class="capitalize">{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kepemilikan</label>
                    <select name="ownership" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                        <option value="company" {{ old('ownership', $vehicle->ownership)==='company' ? 'selected' : '' }}>Perusahaan</option>
                        <option value="personal" {{ old('ownership', $vehicle->ownership)==='personal' ? 'selected' : '' }}>Personal</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cabang</label>
                <select name="branch_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                    @foreach($branches as $b)<option value="{{ $b->id }}" {{ old('branch_id', $vehicle->branch_id)==$b->id ? 'selected' : '' }}>{{ $b->name }}</option>@endforeach
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">Perbarui</button>
                <a href="{{ route('admin.vehicles.index') }}" class="bg-gray-100 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
