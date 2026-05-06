<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staff - Trivo</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen flex" style="background: linear-gradient(135deg, #1a2d5a 0%, #0f1f3d 100%);">
    <div class="flex-1 flex items-center justify-center p-6">
        <div class="w-full max-w-sm">
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo_light.png') }}" alt="Trivo" class="h-12 mx-auto mb-4">
                <h1 class="text-xl font-extrabold text-white">Portal Staff Trivo</h1>
                <p class="text-gray-400 text-sm mt-1">Masuk ke sistem manajemen</p>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl p-8">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('staff.login.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@trivo.id" autocomplete="email"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#6abf2e] focus:border-[#6abf2e] outline-none">
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
                    <button type="submit" class="w-full bg-[#1a2d5a] hover:bg-[#162250] text-white font-bold py-3 rounded-xl transition-colors">
                        Masuk
                    </button>
                </form>

                <div class="mt-5 text-center">
                    <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-[#6abf2e] transition-colors">← Kembali ke Beranda</a>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('customer.login') }}" class="text-xs text-gray-400 hover:text-white transition-colors">Login sebagai Customer →</a>
            </div>
        </div>
    </div>
</body>
</html>
