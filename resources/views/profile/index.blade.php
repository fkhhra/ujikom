@extends('layouts.dashboard')
@section('title', 'Profil - Trivo')

@section('sidebar')
@if(Auth::guard('customer')->check())
    @include('components.customer-sidebar')
@elseif(Auth::user()->role === 'admin' || Auth::user()->role === 'manager')
    @include('components.admin-sidebar')
@elseif(Auth::user()->role === 'cashier')
    @include('components.cashier-sidebar')
@elseif(Auth::user()->role === 'courier')
    @include('components.courier-sidebar')
@endif
@endsection

@section('main-content')
<div class="mb-6">
    <h1 class="text-2xl font-extrabold text-[#1a2b5c]">Profil Saya</h1>
    <p class="text-gray-500 text-sm">Kelola informasi akun Anda</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">
        {{-- EDIT PROFIL --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <h2 class="font-bold text-[#1a2b5c] mb-5">Informasi Pribadi</h2>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full border @error('name') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full border @error('email') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    @if($user instanceof \App\Models\Customer)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat</label>
                        <textarea name="address" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none resize-none">{{ old('address', $user->address) }}</textarea>
                    </div>
                    @endif
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Profil</label>
                        <input type="file" name="photo" accept="image/*"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none">
                    </div>
                </div>
                <button type="submit" class="bg-[#1a2b5c] hover:bg-[#111e42] text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        {{-- GANTI PASSWORD --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <h2 class="font-bold text-[#1a2b5c] mb-5">Ubah Password</h2>
            <form method="POST" action="{{ route('profile.update-password') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Saat Ini</label>
                    <input type="password" name="current_password" required
                        class="w-full border @error('current_password') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none">
                    @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru</label>
                    <input type="password" name="password" required
                        class="w-full border @error('password') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a2b5c] focus:border-transparent outline-none">
                </div>
                <button type="submit" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-all">
                    Ubah Password
                </button>
            </form>
        </div>
    </div>

    {{-- FOTO PROFIL --}}
    <div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center">
            @if($user->photo)
            <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover mx-auto mb-4 ring-4 ring-[#6abf2e]/30">
            <form method="POST" action="{{ route('profile.remove-photo') }}">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition-colors">Hapus foto</button>
            </form>
            @else
            <div class="w-24 h-24 rounded-full bg-[#1a2b5c] flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl font-bold text-[#6abf2e]">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
            </div>
            @endif
            <p class="font-bold text-[#1a2b5c] mt-2">{{ $user->name }}</p>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
            @if(isset($user->role))
            <span class="inline-block mt-2 px-2 py-0.5 bg-[#1a2b5c]/10 text-[#1a2b5c] text-xs font-semibold rounded-full capitalize">{{ $user->role }}</span>
            @endif
        </div>
    </div>
</div>
@endsection
