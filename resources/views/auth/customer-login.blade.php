<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Customer - Trivo</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo_dark.png') }}" alt="Trivo" class="h-12 mx-auto mb-4">
        </a>
        <h1 class="text-2xl font-extrabold text-[#1a2d5a]">Selamat Datang Kembali</h1>
        <p class="text-gray-500 text-sm mt-1">Masuk ke akun customer Anda</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('customer.login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none @error('email') border-red-400 @enderror">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                <input type="password" name="password" placeholder="••••••••" autocomplete="current-password"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input id="remember" type="checkbox" name="remember" class="w-4 h-4 text-[#6abf2e] border-gray-300 rounded focus:ring-[#6abf2e]">
                <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
            </div>
            <button type="submit" class="w-full bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-bold py-3 rounded-xl transition-colors">
                Masuk
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">Belum punya akun? <a href="{{ route('customer.register') }}" class="text-[#6abf2e] font-semibold hover:underline">Daftar sekarang</a></p>
        </div>
        <div class="mt-3 text-center">
            <a href="{{ route('staff.login') }}" class="text-xs text-gray-400 hover:text-[#1a2d5a] transition-colors">Login sebagai Staff →</a>
        </div>
    </div>
</div>
</body>
</html>
