<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Trivo</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
<div class="w-full max-w-md text-center">
    <img src="{{ asset('images/logo_dark.png') }}" alt="Trivo" class="h-12 mx-auto mb-8">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <div class="w-16 h-16 bg-[#6abf2e]/10 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8 text-[#6abf2e]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <h2 class="text-xl font-extrabold text-[#1a2d5a] mb-2">Verifikasi Email Anda</h2>
        <p class="text-gray-500 text-sm mb-6">Kami telah mengirim tautan verifikasi ke alamat email Anda. Silakan periksa inbox atau folder spam.</p>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
        @endif

        <form action="{{ route('customer.verification.send') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <div class="mt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">Keluar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
