@extends('layouts.dashboard')
@section('title', 'Cabang')
@section('page-title', 'Manajemen Cabang')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.branches.create') }}" class="inline-flex items-center gap-2 bg-[#6abf2e] hover:bg-[#5aaa25] text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Cabang
    </a>
</div>
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama Cabang</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Kota</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Alamat</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Telepon</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Staff</th>
                <th class="px-5 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($branches as $b)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3.5 font-semibold text-[#1a2d5a]">{{ $b->name }}</td>
                    <td class="px-5 py-3.5 text-gray-600 hidden sm:table-cell">{{ $b->city }}</td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs hidden md:table-cell max-w-xs truncate">{{ $b->address }}</td>
                    <td class="px-5 py-3.5 text-gray-500 hidden lg:table-cell">{{ $b->phone }}</td>
                    <td class="px-5 py-3.5 text-gray-500 hidden lg:table-cell">{{ $b->users_count ?? 0 }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.branches.edit', $b) }}" class="text-[#6abf2e] text-xs font-semibold hover:underline">Edit</a>
                            <form action="{{ route('admin.branches.destroy', $b) }}" method="POST" onsubmit="return confirm('Hapus cabang ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 text-xs font-semibold hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400">Belum ada cabang</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($branches->hasPages())<div class="p-4 border-t border-gray-50">{{ $branches->links() }}</div>@endif
</div>
@endsection
