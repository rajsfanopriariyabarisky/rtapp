@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 px-4 py-8 bg-white rounded-xl shadow-lg">
    <div class="text-center">
        <div class="mb-6">
            <span class="text-6xl">✅</span>
        </div>
        <h1 class="text-3xl font-bold text-green-600 mb-4">Pembayaran Berhasil</h1>
        <p class="text-lg text-gray-600 mb-8">Terima kasih, transaksi kamu sudah berhasil diproses.</p>
        
        <div class="flex justify-center">
            <a href="{{ route('user.payments.index') }}" 
               class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Lihat Status Pembayaran
            </a>
        </div>
    </div>
</div>
@endsection
