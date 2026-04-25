<li class="px-2 pb-2">
    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Operasional</span>
</li>
<li>
    <a href="{{ route('cashier.shipments.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('cashier.shipments.index') || request()->routeIs('cashier.shipments.show') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('cashier.shipments.index') || request()->routeIs('cashier.shipments.show') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <span class="ms-3 text-sm font-medium">Pengiriman</span>
    </a>
</li>
<li>
    <a href="{{ route('cashier.shipments.create') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('cashier.shipments.create') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('cashier.shipments.create') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span class="ms-3 text-sm font-medium">Buat Pengiriman</span>
    </a>
</li>
<li>
    <a href="{{ route('cashier.payments.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('cashier.payments.*') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('cashier.payments.*') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        <span class="ms-3 text-sm font-medium">Pembayaran</span>
    </a>
</li>

<li class="px-2 pt-4 pb-2">
    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Akun</span>
</li>
<li>
    <a href="{{ route('profile.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('profile.*') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <span class="ms-3 text-sm font-medium">Profil</span>
    </a>
</li>
