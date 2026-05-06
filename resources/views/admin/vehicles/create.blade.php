@extends('layouts.dashboard')
@section('title', 'Tambah Kendaraan')
@section('page-title', 'Tambah Kendaraan Baru')

@section('content')
<div class="max-w-lg">
    <a href="{{ route('admin.vehicles.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1a2d5a] mb-5">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Kembali
    </a>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.vehicles.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Plat Nomor</label>
                <input type="text" name="plate_number" value="{{ old('plate_number') }}" placeholder="B 1234 ABC" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none @error('plate_number') border-red-400 @enderror" style="text-transform: uppercase">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe</label>
                    <select name="type" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white @error('type') border-red-400 @enderror">
                        <option value="">Pilih tipe</option>
                        <option value="motor" {{ old('type')==='motor' ? 'selected' : '' }}>Motor</option>
                        <option value="mobil" {{ old('type')==='mobil' ? 'selected' : '' }}>Mobil</option>
                        <option value="truck" {{ old('type')==='truck' ? 'selected' : '' }}>Truck</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kepemilikan</label>
                    <select name="ownership" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white @error('ownership') border-red-400 @enderror">
                        <option value="">Pilih</option>
                        <option value="company" {{ old('ownership')==='company' ? 'selected' : '' }}>Perusahaan</option>
                        <option value="personal" {{ old('ownership')==='personal' ? 'selected' : '' }}>Personal</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cabang</label>
                <select name="branch_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white @error('branch_id') border-red-400 @enderror">
                    <option value="">Pilih cabang</option>
                    @foreach($branches as $b)<option value="{{ $b->id }}" {{ old('branch_id')==$b->id ? 'selected' : '' }}>{{ $b->name }}</option>@endforeach
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">Simpan</button>
                <a href="{{ route('admin.vehicles.index') }}" class="bg-gray-100 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
