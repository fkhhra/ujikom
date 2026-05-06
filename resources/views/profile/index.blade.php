@php
    $isCustomer = auth()->guard('customer')->check();
    $layout = $isCustomer ? 'layouts.customer' : 'layouts.dashboard';
@endphp

@extends($layout)
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-5">
        {{-- Avatar --}}
        <div class="flex items-center gap-5 mb-6 pb-6 border-b border-gray-100">
            <div class="relative">
                @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-[#6abf2e]/30">
                @else
                    <div class="w-16 h-16 rounded-full bg-[#1a2d5a] flex items-center justify-center text-white text-2xl font-extrabold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div>
                <h2 class="font-bold text-[#1a2d5a] text-lg">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                @if(!$isCustomer)
                    <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-[#1a2d5a]/10 text-[#1a2d5a] capitalize">{{ $user->role }}</span>
                @endif
            </div>
        </div>

        {{-- Update form --}}
        <h3 class="font-bold text-[#1a2d5a] mb-4">Ubah Informasi</h3>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2 sm:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                @if($isCustomer)
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota</label>
                    <input type="text" name="city" value="{{ old('city', $user->city) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat</label>
                    <textarea name="address" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none resize-none">{{ old('address', $user->address) }}</textarea>
                </div>
                @endif
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Profil</label>
                <div class="flex items-center gap-3">
                    <input type="file" name="photo" accept="image/*" class="flex-1 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#6abf2e]/10 file:text-[#6abf2e]">
                    @if($user->photo)
                        <form action="{{ route('profile.remove-photo') }}" method="POST" onsubmit="return confirm('Hapus foto profil?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 text-xs font-semibold hover:underline whitespace-nowrap">Hapus foto</button>
                        </form>
                    @endif
                </div>
                @error('photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
                Simpan Perubahan
            </button>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-[#1a2d5a] mb-4">Ubah Kata Sandi</h3>
        <form action="{{ route('profile.update-password') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none @error('current_password') border-red-400 @enderror">
                @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kata Sandi Baru</label>
                    <input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none @error('password') border-red-400 @enderror">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Baru</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
                </div>
            </div>
            <button type="submit" class="bg-[#1a2d5a] hover:bg-[#162250] text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
                Ubah Kata Sandi
            </button>
        </form>
    </div>
</div>
@endsection
