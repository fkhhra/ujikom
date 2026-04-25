<li class="px-2 pb-2">
    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tugas</span>
</li>
<li>
    <a href="{{ route('courier.shipments.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('courier.shipments.index') ? 'bg-[#1a2b5c] text-white' : 'text-gray-700 hover:bg-gray-100' }} group">
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('courier.shipments.index') ? 'text-[#6abf2e]' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <span class="ms-3 text-sm font-medium">Tugas Saya</span>
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
