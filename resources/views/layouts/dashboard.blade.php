<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Trivo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.625rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #cbd5e1; transition: all 0.15s; }
        .sidebar-link:hover { background-color: rgba(255,255,255,0.08); color: #fff; }
        .sidebar-link.active { background-color: #6abf2e; color: #fff; }
        .sidebar-link svg { width: 1.125rem; height: 1.125rem; flex-shrink: 0; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">
    {{-- Sidebar --}}
    <aside id="sidebar" class="w-64 bg-[#1a2d5a] flex-shrink-0 flex flex-col overflow-y-auto transition-transform -translate-x-full md:translate-x-0 fixed md:relative z-40 h-full">
        <div class="flex items-center justify-between px-4 py-5 border-b border-white/10">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo_light.png') }}" alt="Trivo" class="h-8">
            </a>
            <button id="close-sidebar" class="md:hidden text-white/60 hover:text-white">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1">
            @php
                $role = auth()->guard('web')->user()?->role ?? '';
            @endphp

            @if(in_array($role, ['admin', 'manager']))
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Utama</p>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.shipments.index') }}" class="sidebar-link {{ request()->routeIs('admin.shipments.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Pengiriman
                </a>
                <a href="{{ route('admin.payments.index') }}" class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Pembayaran
                </a>
                <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Laporan
                </a>

                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-4 mb-2">Manajemen</p>
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Staff
                </a>
                <a href="{{ route('admin.vehicles.index') }}" class="sidebar-link {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    Kendaraan
                </a>
                @if($role === 'admin')
                    <a href="{{ route('admin.branches.index') }}" class="sidebar-link {{ request()->routeIs('admin.branches.*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Cabang
                    </a>
                    <a href="{{ route('admin.rates.index') }}" class="sidebar-link {{ request()->routeIs('admin.rates.*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Tarif
                    </a>
                @endif

            @elseif($role === 'cashier')
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Kasir</p>
                <a href="{{ route('cashier.dashboard') }}" class="sidebar-link {{ request()->routeIs('cashier.dashboard') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('cashier.shipments.index') }}" class="sidebar-link {{ request()->routeIs('cashier.shipments.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Pengiriman
                </a>
                <a href="{{ route('cashier.payments.index') }}" class="sidebar-link {{ request()->routeIs('cashier.payments.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Pembayaran
                </a>

            @elseif($role === 'courier')
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Kurir</p>
                <a href="{{ route('courier.dashboard') }}" class="sidebar-link {{ request()->routeIs('courier.dashboard') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('courier.shipments.index') }}" class="sidebar-link {{ request()->routeIs('courier.shipments.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Pengiriman Saya
                </a>
            @endif
        </nav>

        <div class="px-3 py-4 border-t border-white/10">
            <a href="{{ route('profile.index') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left text-red-400 hover:text-red-300 hover:bg-red-500/10">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay for mobile --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden"></div>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Top bar --}}
        <header class="bg-white border-b border-gray-200 px-4 sm:px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button id="open-sidebar" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="text-base font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-gray-500">@yield('page-subtitle', '')</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @php $staffUser = auth()->guard('web')->user(); @endphp
                @if($staffUser)
                    <div class="hidden sm:flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-[#1a2d5a] flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr($staffUser->name, 0, 1)) }}
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-semibold text-gray-700">{{ $staffUser->name }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ $staffUser->role }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
            <div data-auto-dismiss class="mx-4 sm:mx-6 mt-4 flex items-center p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div data-auto-dismiss class="mx-4 sm:mx-6 mt-4 flex items-center p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mx-4 sm:mx-6 mt-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <main class="flex-1 overflow-y-auto p-4 sm:p-6">
            @yield('content')
        </main>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const openBtn = document.getElementById('open-sidebar');
    const closeBtn = document.getElementById('close-sidebar');
    openBtn?.addEventListener('click', () => { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('hidden'); });
    closeBtn?.addEventListener('click', () => { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); });
    overlay?.addEventListener('click', () => { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); });
</script>

@stack('scripts')
</body>
</html>
