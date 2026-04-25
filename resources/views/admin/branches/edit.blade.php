@extends('layouts.dashboard')
@section('title', 'Edit Cabang - Trivo Admin')
@section('sidebar')
@include('components.admin-sidebar')
@endsection
@section('main-content')
<div class="mb-6">
    <a href="{{ route('admin.branches.index') }}" class="text-sm text-gray-500 hover:text-[#1a2b5c] transition-colors">← Kembali</a>
    <h1 class="text-2xl font-extrabold text-[#1a2b5c] mt-1">Edit Cabang</h1>
    <p class="text-gray-500 text-sm">{{ $branch->name }}</p>
</div>
<div class="max-w-lg">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <form method="POST" action="{{ route('admin.branches.update', $branch) }}" class="space-y-4">
            @csrf @method('PUT')
            @foreach(['name'=>'Nama Cabang','city'=>'Kota','address'=>'Alamat','phone'=>'Telepon'] as $field => $label)
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ $label }}</label>
                <input type="text" name="{{ $field }}" value="{{ old($field, $branch->$field) }}" required
                    class="w-full border @error($field) border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                @error($field)<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            @endforeach
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">Perbarui</button>
                <a href="{{ route('admin.branches.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
