@extends('layouts.dashboard')
@section('title', 'Pengguna - Trivo Admin')

@section('sidebar')
@include('components.admin-sidebar')
@endsection

@section('main-content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-[#1a2b5c]">Pengguna</h1>
        <p class="text-gray-500 text-sm">Kelola akun staff dan kurir</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-4 py-2 rounded-lg text-sm transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..."
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Role</label>
            <select name="role" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
                <option value="manager" {{ request('role')=='manager'?'selected':'' }}>Manager</option>
                <option value="cashier" {{ request('role')=='cashier'?'selected':'' }}>Kasir</option>
                <option value="courier" {{ request('role')=='courier'?'selected':'' }}>Kurir</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Cabang</label>
            <select name="branch_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a2b5c] outline-none bg-white">
                <option value="">Semua Cabang</option>
                @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ request('branch_id')==$branch->id?'selected':'' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-[#1a2b5c] hover:bg-[#111e42] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all">Filter</button>
        @if(request()->anyFilled(['search','role','branch_id']))
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-red-500 py-2">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">Email</th>
                    <th class="px-5 py-3 text-left">Role</th>
                    <th class="px-5 py-3 text-left">Cabang</th>
                    <th class="px-5 py-3 text-left">Status</th>
                    <th class="px-5 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition-colors {{ $user->trashed() ? 'opacity-50' : '' }}">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#1a2b5c] flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-600">{{ $user->email }}</td>
                    <td class="px-5 py-3">
                        @php
                        $roleColors = ['admin'=>'bg-purple-100 text-purple-700','manager'=>'bg-blue-100 text-blue-700','cashier'=>'bg-yellow-100 text-yellow-700','courier'=>'bg-green-100 text-green-700'];
                        $rc = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $rc }} capitalize">{{ $user->role }}</span>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $user->branch?->name ?? '-' }}</td>
                    <td class="px-5 py-3">
                        @if($user->trashed())
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-600">Nonaktif</span>
                        @else
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-[#1a2b5c] hover:text-[#6abf2e] font-semibold text-xs transition-colors">Edit</a>
                            @if(!$user->trashed())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Nonaktifkan pengguna ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs transition-colors">Nonaktifkan</button>
                            </form>
                            @else
                            <form method="POST" action="{{ route('admin.users.restore', $user) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-green-600 hover:text-green-800 font-semibold text-xs transition-colors">Aktifkan</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-400 text-sm">Tidak ada pengguna</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $users->links() }}</div>
    @endif
</div>
@endsection
