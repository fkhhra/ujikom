@extends('layouts.dashboard')
@section('title', 'Tambah Kendaraan - Trivo Admin')
@section('sidebar')
@include('components.admin-sidebar')
@endsection
@section('main-content')
<div class="mb-6">
    <a href="{{ route('admin.vehicles.index') }}" class="text-sm text-gray-500 hover:text-[#1a2b5c] transition-colors">← Kembali</a>
    <h1 class="text-2xl font-extrabold text-[#1a2b5c] mt-1">Tambah Kendaraan</h1>
</div>
<div class="max-w-lg">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <form method="POST" action="{{ route('admin.vehicles.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Plat Nomor</label>
                <input type="text" name="plate_number" value="{{ old('plate_number') }}" required placeholder="B 1234 XYZ"
                    class="w-full border @error('plate_number') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none uppercase">
                @error('plate_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe</label>
                    <select name="type" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                        <option value="">Pilih...</option>
                        <option value="motor" {{ old('type')=='motor'?'selected':'' }}>Motor</option>
                        <option value="mobil" {{ old('type')=='mobil'?'selected':'' }}>Mobil</option>
                        <option value="truck" {{ old('type')=='truck'?'selected':'' }}>Truck</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kepemilikan</label>
                    <select name="ownership" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                        <option value="company" {{ old('ownership')=='company'?'selected':'' }}>Perusahaan</option>
                        <option value="personal" {{ old('ownership')=='personal'?'selected':'' }}>Pribadi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Merek</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" placeholder="Honda, Toyota..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Model</label>
                    <input type="text" name="model" value="{{ old('model') }}" placeholder="Vario, Avanza..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cabang</label>
                <select name="branch_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                    <option value="">Pilih cabang...</option>
                    @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id')==$branch->id?'selected':'' }}>{{ $branch->name }} — {{ $branch->city }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">Simpan</button>
                <a href="{{ route('admin.vehicles.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
