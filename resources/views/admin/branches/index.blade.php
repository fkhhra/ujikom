@extends('layouts.dashboard')
@section('title', 'Cabang - Trivo Admin')

@section('sidebar')
@include('components.admin-sidebar')
@endsection

@section('main-content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-[#1a2b5c]">Cabang</h1>
        <p class="text-gray-500 text-sm">Kelola cabang Trivo</p>
    </div>
    <a href="{{ route('admin.branches.create') }}" class="bg-[#6abf2e] hover:bg-[#4e9020] text-white font-semibold px-4 py-2 rounded-lg text-sm transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Cabang
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-5 py-3 text-left">Nama Cabang</th>
                    <th class="px-5 py-3 text-left">Kota</th>
                    <th class="px-5 py-3 text-left">Alamat</th>
                    <th class="px-5 py-3 text-left">Telepon</th>
                    <th class="px-5 py-3 text-left">Staff</th>
                    <th class="px-5 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($branches as $branch)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3 font-semibold text-gray-800">{{ $branch->name }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $branch->city }}</td>
                    <td class="px-5 py-3 text-gray-500 text-xs max-w-48 truncate">{{ $branch->address }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $branch->phone }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">{{ $branch->users_count }}</span>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.branches.edit', $branch) }}" class="text-[#1a2b5c] hover:text-[#6abf2e] font-semibold text-xs transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.branches.destroy', $branch) }}" onsubmit="return confirm('Hapus cabang ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-400 text-sm">Belum ada cabang</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($branches->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $branches->links() }}</div>
    @endif
</div>
@endsection
