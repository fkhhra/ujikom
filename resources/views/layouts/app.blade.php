<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Trivo - Jasa Pengiriman Terpercaya')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .brand-navy { color: #1a2d5a; }
        .bg-brand-navy { background-color: #1a2d5a; }
        .brand-green { color: #6abf2e; }
        .bg-brand-green { background-color: #6abf2e; }
        .btn-primary { background-color: #6abf2e; color: #fff; font-weight: 600; padding: 0.625rem 1.5rem; border-radius: 0.5rem; transition: background-color 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-primary:hover { background-color: #5aaa25; }
        .btn-navy { background-color: #1a2d5a; color: #fff; font-weight: 600; padding: 0.625rem 1.5rem; border-radius: 0.5rem; transition: background-color 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-navy:hover { background-color: #162250; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('images/logo_dark.png') }}" alt="Trivo" class="h-10">
                </a>
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-[#1a2d5a] transition-colors {{ request()->routeIs('home') ? 'text-[#6abf2e] font-semibold' : '' }}">Beranda</a>
                    <a href="{{ route('tracking') }}" class="text-sm font-medium text-gray-600 hover:text-[#1a2d5a] transition-colors {{ request()->routeIs('tracking') ? 'text-[#6abf2e] font-semibold' : '' }}">Lacak Paket</a>
                    @auth('customer')
                        <a href="{{ route('customer.dashboard') }}" class="btn-primary text-sm">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('customer.login') }}" class="text-sm font-medium text-gray-600 hover:text-[#1a2d5a] transition-colors">Masuk</a>
                        <a href="{{ route('customer.register') }}" class="btn-primary text-sm">Daftar</a>
                    @endauth
                </div>
                <button data-collapse-toggle="mobile-menu" type="button" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-2">
            <a href="{{ route('home') }}" class="block py-2 text-sm font-medium text-gray-700 hover:text-[#6abf2e]">Beranda</a>
            <a href="{{ route('tracking') }}" class="block py-2 text-sm font-medium text-gray-700 hover:text-[#6abf2e]">Lacak Paket</a>
            @auth('customer')
                <a href="{{ route('customer.dashboard') }}" class="block py-2 text-sm font-semibold text-[#6abf2e]">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 text-sm font-medium text-red-600">Keluar</button>
                </form>
            @else
                <a href="{{ route('customer.login') }}" class="block py-2 text-sm font-medium text-gray-700">Masuk</a>
                <a href="{{ route('customer.register') }}" class="block py-2 text-sm font-semibold text-[#6abf2e]">Daftar</a>
            @endauth
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
        <div data-auto-dismiss class="fixed top-20 right-4 z-50 flex items-center p-4 max-w-sm bg-white border-l-4 border-green-500 rounded-lg shadow-lg">
            <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <p class="text-sm text-gray-700">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div data-auto-dismiss class="fixed top-20 right-4 z-50 flex items-center p-4 max-w-sm bg-white border-l-4 border-red-500 rounded-lg shadow-lg">
            <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <p class="text-sm text-gray-700">{{ session('error') }}</p>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-[#1a2d5a] text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <img src="{{ asset('images/logo_light.png') }}" alt="Trivo" class="h-10 mb-4">
                    <p class="text-sm text-gray-300 max-w-xs leading-relaxed">Solusi pengiriman cepat, aman, dan terpercaya untuk kebutuhan bisnis maupun personal Anda di seluruh Indonesia.</p>
                    <div class="flex gap-3 mt-4">
                        <div class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#6abf2e] transition-colors cursor-pointer">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </div>
                        <div class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#6abf2e] transition-colors cursor-pointer">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-sm uppercase tracking-wider text-gray-300 mb-4">Layanan</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-[#6abf2e] transition-colors">Pengiriman Reguler</a></li>
                        <li><a href="{{ route('tracking') }}" class="hover:text-[#6abf2e] transition-colors">Lacak Paket</a></li>
                        <li><a href="{{ route('home') }}#cek-tarif" class="hover:text-[#6abf2e] transition-colors">Cek Tarif</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-sm uppercase tracking-wider text-gray-300 mb-4">Akun</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('customer.login') }}" class="hover:text-[#6abf2e] transition-colors">Login Customer</a></li>
                        <li><a href="{{ route('customer.register') }}" class="hover:text-[#6abf2e] transition-colors">Daftar</a></li>
                        <li><a href="{{ route('staff.login') }}" class="hover:text-[#6abf2e] transition-colors">Login Staff</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 mt-8 pt-6 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Trivo. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
