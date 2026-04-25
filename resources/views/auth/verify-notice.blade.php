@extends('layouts.app')
@section('title', 'Verifikasi Email - Trivo')
@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-6">
    <div class="max-w-md w-full text-center">
        <img src="{{ asset('images/branding/logo.png') }}" alt="Trivo" class="h-12 mx-auto mb-6">
        <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100">
            <div class="w-16 h-16 bg-[#f0f7e8] rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[#6abf2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-xl font-extrabold text-[#1a2b5c] mb-2">Verifikasi Email Anda</h1>
            <p class="text-gray-500 text-sm mb-6">Kami telah mengirimkan tautan verifikasi ke email Anda. Silakan cek inbox atau folder spam.</p>

            @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('customer.verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-[#1a2b5c] hover:bg-[#111e42] text-white font-semibold py-3 rounded-lg text-sm transition-all">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-red-600 transition-colors">Keluar dari akun</button>
            </form>
        </div>
    </div>
</div>
@endsection
