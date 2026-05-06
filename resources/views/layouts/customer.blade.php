<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Customer') - Trivo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .nav-link { padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #6b7280; transition: all 0.15s; }
        .nav-link:hover { color: #1a2d5a; background-color: #f3f4f6; }
        .nav-link.active { color: #6abf2e; font-weight: 600; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">

<nav class="bg-white shadow-sm sticky top-0 z-40 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo_dark.png') }}" alt="Trivo" class="h-9">
            </a>
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('tracking') }}" class="nav-link">Lacak Paket</a>
                <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">Profil</a>
            </div>
            <div class="flex items-center gap-3">
                @php $cust = auth()->guard('customer')->user(); @endphp
                <div class="hidden sm:flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-[#6abf2e] flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr($cust->name ?? 'U', 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700">{{ $cust->name ?? '' }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-red-600 transition-colors px-2 py-1 rounded">Keluar</button>
                </form>
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </div>
    <div id="mobile-nav" class="hidden md:hidden border-t border-gray-100 px-4 py-3 space-y-1">
        <a href="{{ route('customer.dashboard') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">Dashboard</a>
        <a href="{{ route('tracking') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">Lacak Paket</a>
        <a href="{{ route('profile.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">Profil</a>
    </div>
</nav>

@if(session('success'))
    <div data-auto-dismiss class="max-w-7xl mx-auto px-4 sm:px-6 mt-4 flex items-center p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div data-auto-dismiss class="max-w-7xl mx-auto px-4 sm:px-6 mt-4 flex items-center p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
        {{ session('error') }}
    </div>
@endif

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @yield('content')
</main>

<script>
    document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
        document.getElementById('mobile-nav').classList.toggle('hidden');
    });
</script>

@stack('scripts')
</body>
</html>
