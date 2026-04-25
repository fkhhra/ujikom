@php $role = Auth::guard('web')->user()?->role; @endphp

<li class="px-2 pb-2">
    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Menu Utama</span>
</li>
<li>
    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/></svg>
        <span class="ms-3 text-sm font-medium">Dashboard</span>
    </a>
</li>
<li>
    <a href="{{ route('admin.reports.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.reports.*') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <span class="ms-3 text-sm font-medium">Laporan</span>
    </a>
</li>

<li class="px-2 pt-4 pb-2">
    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Transaksi</span>
</li>
<li>
    <a href="{{ route('admin.shipments.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.shipments.*') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.shipments.*') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <span class="ms-3 text-sm font-medium">Pengiriman</span>
    </a>
</li>
<li>
    <a href="{{ route('admin.payments.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.payments.*') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.payments.*') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        <span class="ms-3 text-sm font-medium">Pembayaran</span>
    </a>
</li>

<li class="px-2 pt-4 pb-2">
    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Master Data</span>
</li>
<li>
    <a href="{{ route('admin.users.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        <span class="ms-3 text-sm font-medium">Pengguna</span>
    </a>
</li>
<li>
    <a href="{{ route('admin.vehicles.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.vehicles.*') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.vehicles.*') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17H4m12 0h-4m2-9H6m12 0H6"/></svg>
        <span class="ms-3 text-sm font-medium">Kendaraan</span>
    </a>
</li>
@if($role === 'admin')
<li>
    <a href="{{ route('admin.branches.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.branches.*') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.branches.*') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        <span class="ms-3 text-sm font-medium">Cabang</span>
    </a>
</li>
<li>
    <a href="{{ route('admin.rates.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.rates.*') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.rates.*') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        <span class="ms-3 text-sm font-medium">Tarif</span>
    </a>
</li>
@endif

<li class="px-2 pt-4 pb-2">
    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pengaturan</span>
</li>
<li>
    <a href="{{ route('profile.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('profile.*') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <span class="ms-3 text-sm font-medium">Profil</span>
    </a>
</li>
