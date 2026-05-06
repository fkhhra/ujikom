@extends('layouts.dashboard')
@section('title', 'Edit Cabang')
@section('page-title', 'Edit Cabang')

@section('content')
<div class="max-w-lg">
    <a href="{{ route('admin.branches.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1a2d5a] mb-5">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Kembali
    </a>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.branches.update', $branch) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Cabang</label>
                <input type="text" name="name" value="{{ old('name', $branch->name) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota</label>
                <input type="text" name="city" value="{{ old('city', $branch->city) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat</label>
                <textarea name="address" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none resize-none">{{ old('address', $branch->address) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $branch->phone) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">Perbarui</button>
                <a href="{{ route('admin.branches.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
