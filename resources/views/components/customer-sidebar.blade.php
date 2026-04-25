<li class="px-2 pb-2">
    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Menu</span>
</li>
<li>
    <a href="{{ route('customer.dashboard') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('customer.dashboard') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('customer.dashboard') ? 'text-[#6abf2e]' : 'text-gray-500 group-hover:text-gray-900' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/></svg>
        <span class="ms-3 text-sm font-medium">Dashboard</span>
    </a>
</li>
<li>
    <a href="{{ route('tracking') }}" class="flex items-center p-2 rounded-lg text-gray-700 hover:bg-gray-100 group">
        <svg class="w-5 h-5 flex-shrink-0 text-gray-500 group-hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <span class="ms-3 text-sm font-medium">Lacak Paket</span>
    </a>
</li>

<li class="px-2 pt-4 pb-2">
    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Akun</span>
</li>
<li>
    <a href="{{ route('profile.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('profile.*') ? 'text-[#6abf2e]' : 'text-gray-500 group-hover:text-gray-900' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <span class="ms-3 text-sm font-medium">Profil Saya</span>
    </a>
</li>
