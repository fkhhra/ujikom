@extends('layouts.dashboard')
@section('title', 'Staff')
@section('page-title', 'Manajemen Staff')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Staff
    </a>
</div>
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="p-4 border-b border-gray-50">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-48 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..." class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none">
            </div>
            <select name="role" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                <option value="">Semua Role</option>
                @foreach(['admin'=>'Admin','manager'=>'Manager','cashier'=>'Kasir','courier'=>'Kurir'] as $v => $l)
                    <option value="{{ $v }}" {{ request('role')===$v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
            <select name="branch_id" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#6abf2e] outline-none bg-white">
                <option value="">Semua Cabang</option>
                @foreach($branches as $b)<option value="{{ $b->id }}" {{ request('branch_id')==$b->id ? 'selected' : '' }}>{{ $b->name }}</option>@endforeach
            </select>
            <button type="submit" class="bg-[#1a2d5a] text-white text-sm font-semibold px-5 py-2 rounded-lg">Filter</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Email</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Role</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Cabang</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="px-5 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $u)
                <tr class="hover:bg-gray-50/50 {{ $u->trashed() ? 'opacity-50' : '' }}">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-[#1a2d5a] flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ strtoupper(substr($u->name,0,1)) }}</div>
                            <span class="font-medium text-gray-700">{{ $u->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-500 hidden sm:table-cell">{{ $u->email }}</td>
                    <td class="px-5 py-3.5">
                        @php $roleColors = ['admin'=>'bg-purple-100 text-purple-700','manager'=>'bg-blue-100 text-blue-700','cashier'=>'bg-orange-100 text-orange-700','courier'=>'bg-green-100 text-green-700']; @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $roleColors[$u->role] ?? 'bg-gray-100 text-gray-700' }} capitalize">{{ $u->role }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs hidden md:table-cell">{{ $u->branch?->name ?? '-' }}</td>
                    <td class="px-5 py-3.5">
                        @if($u->trashed())
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Nonaktif</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex gap-3">
                            @if(!$u->trashed())
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="text-[#6abf2e] text-xs font-semibold hover:underline">Edit</a>
                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Nonaktifkan user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 text-xs font-semibold hover:underline">Nonaktif</button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.restore', $u->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-blue-500 text-xs font-semibold hover:underline">Aktifkan</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400">Belum ada data staff</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())<div class="p-4 border-t border-gray-50">{{ $users->links() }}</div>@endif
</div>
@endsection
