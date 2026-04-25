@extends('layouts.dashboard')
@section('title', 'Edit Kendaraan - Trivo Admin')
@section('sidebar')
@include('components.admin-sidebar')
@endsection
@section('main-content')
<div class="mb-6">
    <a href="{{ route('admin.vehicles.index') }}" class="text-sm text-gray-500 hover:text-[#1a2b5c] transition-colors">← Kembali</a>
    <h1 class="text-2xl font-extrabold text-[#1a2b5c] mt-1">Edit Kendaraan</h1>
    <p class="text-gray-500 text-sm font-mono">{{ $vehicle->plate_number }}</p>
</div>
<div class="max-w-lg">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <form method="POST" action="{{ route('admin.vehicles.update', $vehicle) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Plat Nomor</label>
                <input type="text" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none uppercase">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe</label>
                    <select name="type" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                        <option value="motor" {{ $vehicle->type=='motor'?'selected':'' }}>Motor</option>
                        <option value="mobil" {{ $vehicle->type=='mobil'?'selected':'' }}>Mobil</option>
                        <option value="truck" {{ $vehicle->type=='truck'?'selected':'' }}>Truck</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kepemilikan</label>
                    <select name="ownership" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                        <option value="company" {{ $vehicle->ownership=='company'?'selected':'' }}>Perusahaan</option>
                        <option value="personal" {{ $vehicle->ownership=='personal'?'selected':'' }}>Pribadi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Merek</label>
                    <input type="text" name="brand" value="{{ old('brand', $vehicle->brand) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Model</label>
                    <input type="text" name="model" value="{{ old('model', $vehicle->model) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cabang</label>
                <select name="branch_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                    @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $vehicle->branch_id==$branch->id?'selected':'' }}>{{ $branch->name }} — {{ $branch->city }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">Perbarui</button>
                <a href="{{ route('admin.vehicles.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
