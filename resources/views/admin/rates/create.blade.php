@extends('layouts.dashboard')
@section('title', 'Tambah Tarif - Trivo Admin')
@section('sidebar')
@include('components.admin-sidebar')
@endsection
@section('main-content')
<div class="mb-6">
    <a href="{{ route('admin.rates.index') }}" class="text-sm text-gray-500 hover:text-[#1a2b5c] transition-colors">← Kembali</a>
    <h1 class="text-2xl font-extrabold text-[#1a2b5c] mt-1">Tambah Tarif</h1>
</div>
<div class="max-w-lg">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <form method="POST" action="{{ route('admin.rates.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota Asal</label>
                <input type="text" name="origin_city" value="{{ old('origin_city') }}" required list="cities-list"
                    class="w-full border @error('origin_city') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                <datalist id="cities-list">
                    @foreach($cities as $city)<option value="{{ $city }}">@endforeach
                </datalist>
                @error('origin_city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota Tujuan</label>
                <input type="text" name="destination_city" value="{{ old('destination_city') }}" required list="cities-list"
                    class="w-full border @error('destination_city') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                @error('destination_city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tarif per kg (Rp)</label>
                <input type="number" name="price_per_kg" value="{{ old('price_per_kg') }}" required min="0"
                    class="w-full border @error('price_per_kg') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                @error('price_per_kg')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Estimasi (hari)</label>
                <input type="number" name="estimated_days" value="{{ old('estimated_days') }}" required min="1"
                    class="w-full border @error('estimated_days') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                @error('estimated_days')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">Simpan</button>
                <a href="{{ route('admin.rates.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
