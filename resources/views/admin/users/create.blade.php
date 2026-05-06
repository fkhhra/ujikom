@extends('layouts.dashboard')
@section('title', 'Tambah Staff')
@section('page-title', 'Tambah Staff Baru')

@section('content')
<div class="max-w-lg">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1a2d5a] mb-5">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Kembali
    </a>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none @error('name') border-red-400 @enderror">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none @error('email') border-red-400 @enderror">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none @error('password') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Role</label>
                <select name="role" id="role-select" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white @error('role') border-red-400 @enderror">
                    <option value="">Pilih role</option>
                    @foreach(['admin'=>'Admin','manager'=>'Manager','cashier'=>'Kasir','courier'=>'Kurir'] as $v => $l)
                        <option value="{{ $v }}" {{ old('role')===$v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cabang</label>
                <select name="branch_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white @error('branch_id') border-red-400 @enderror">
                    <option value="">Pilih cabang</option>
                    @foreach($branches as $b)<option value="{{ $b->id }}" {{ old('branch_id')==$b->id ? 'selected' : '' }}>{{ $b->name }}</option>@endforeach
                </select>
            </div>
            <div id="vehicle-section" class="hidden">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kendaraan (Kurir)</label>
                <select name="vehicle_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                    <option value="">Pilih kendaraan (opsional)</option>
                    @foreach($vehicles as $v)<option value="{{ $v->id }}" {{ old('vehicle_id')==$v->id ? 'selected' : '' }}>{{ $v->plate_number }} ({{ $v->type }})</option>@endforeach
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('role-select').addEventListener('change', function() {
    document.getElementById('vehicle-section').classList.toggle('hidden', this.value !== 'courier');
});
if (document.getElementById('role-select').value === 'courier') document.getElementById('vehicle-section').classList.remove('hidden');
</script>
@endpush
