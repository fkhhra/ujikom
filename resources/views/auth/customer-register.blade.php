<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Customer - Trivo</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 py-8">
<div class="w-full max-w-lg">
    <div class="text-center mb-8">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo_dark.png') }}" alt="Trivo" class="h-12 mx-auto mb-4">
        </a>
        <h1 class="text-2xl font-extrabold text-[#1a2d5a]">Buat Akun Baru</h1>
        <p class="text-gray-500 text-sm mt-1">Daftar dan mulai kirim paket dengan mudah</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        @if($errors->any())
            <div class="mb-5 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                <ul class="space-y-1 list-disc list-inside">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda" maxlength="50"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none @error('name') border-red-400 @enderror">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none @error('email') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" placeholder="Min. 8 karakter"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none @error('password') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xx-xxxx-xxxx" maxlength="15"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none @error('phone') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota</label>
                    <input type="text" name="city" value="{{ old('city') }}" placeholder="Jakarta"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none @error('city') border-red-400 @enderror">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Lengkap</label>
                    <textarea name="address" rows="2" placeholder="Jl. Contoh No. 1, RT 01/RW 02, Kelurahan..."
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none resize-none @error('address') border-red-400 @enderror">{{ old('address') }}</textarea>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-bold py-3 rounded-xl transition-colors mt-2">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">Sudah punya akun? <a href="{{ route('customer.login') }}" class="text-[#6abf2e] font-semibold hover:underline">Masuk di sini</a></p>
        </div>
    </div>
</div>
</body>
</html>
