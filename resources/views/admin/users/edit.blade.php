@extends('layouts.dashboard')
@section('title', 'Edit Pengguna - Trivo Admin')

@section('sidebar')
@include('components.admin-sidebar')
@endsection

@section('main-content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-[#1a2b5c] transition-colors">← Kembali</a>
    <h1 class="text-2xl font-extrabold text-[#1a2b5c] mt-1">Edit Pengguna</h1>
    <p class="text-gray-500 text-sm">{{ $user->name }}</p>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full border @error('name') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full border @error('email') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="password" name="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Role</label>
                    <select name="role" required id="role-select"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                        <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                        <option value="manager" {{ $user->role=='manager'?'selected':'' }}>Manager</option>
                        <option value="cashier" {{ $user->role=='cashier'?'selected':'' }}>Kasir</option>
                        <option value="courier" {{ $user->role=='courier'?'selected':'' }}>Kurir</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cabang</label>
                    <select name="branch_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                        <option value="">Pilih cabang...</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ $user->branch_id==$branch->id?'selected':'' }}>{{ $branch->name }} — {{ $branch->city }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="vehicle-field" class="sm:col-span-2 {{ $user->role !== 'courier' ? 'hidden' : '' }}">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kendaraan</label>
                    <select name="vehicle_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                        <option value="">Tanpa kendaraan</option>
                        @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ $user->vehicle?->id==$vehicle->id?'selected':'' }}>{{ $vehicle->plate_number }} — {{ $vehicle->type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">Perbarui</button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('role-select').addEventListener('change', function() {
    document.getElementById('vehicle-field').classList.toggle('hidden', this.value !== 'courier');
});
</script>
@endpush
