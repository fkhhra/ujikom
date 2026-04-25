@extends('layouts.dashboard')
@section('title', 'Edit Tarif - Trivo Admin')
@section('sidebar')
@include('components.admin-sidebar')
@endsection
@section('main-content')
<div class="mb-6">
    <a href="{{ route('admin.rates.index') }}" class="text-sm text-gray-500 hover:text-[#1a2b5c] transition-colors">← Kembali</a>
    <h1 class="text-2xl font-extrabold text-[#1a2b5c] mt-1">Edit Tarif</h1>
    <p class="text-gray-500 text-sm">{{ $rate->origin_city }} → {{ $rate->destination_city }}</p>
</div>
<div class="max-w-lg">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <form method="POST" action="{{ route('admin.rates.update', $rate) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota Asal</label>
                <input type="text" name="origin_city" value="{{ old('origin_city', $rate->origin_city) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota Tujuan</label>
                <input type="text" name="destination_city" value="{{ old('destination_city', $rate->destination_city) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tarif per kg (Rp)</label>
                <input type="number" name="price_per_kg" value="{{ old('price_per_kg', $rate->price_per_kg) }}" required min="0"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Estimasi (hari)</label>
                <input type="number" name="estimated_days" value="{{ old('estimated_days', $rate->estimated_days) }}" required min="1"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">Perbarui</button>
                <a href="{{ route('admin.rates.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
