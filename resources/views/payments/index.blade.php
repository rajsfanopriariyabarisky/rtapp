@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-4 py-8 bg-white dark:bg-gray-800 rounded-xl shadow" x-data="{ loading: false, showUploadForm: false }">
    <h1 class="text-2xl font-bold mb-6 text-blue-700 dark:text-blue-400 flex items-center gap-2">
        <span>💳</span> Pembayaran Saya
    </h1>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-800 dark:text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Himbauan tambahan --}}
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-600 text-blue-800 dark:text-blue-200 px-4 py-3 rounded mb-6">
        <div class="flex items-start gap-2">
            <span class="text-lg">📢</span>
            <div>
                <strong>Himbauan:</strong> Setelah berhasil melakukan pembayaran, harap unggah bukti transfer pada kolom aksi agar admin dapat memverifikasi dan mengubah status menjadi <strong>Lunas</strong>.
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-center">
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-800 dark:text-gray-200">🏷 Judul</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-800 dark:text-gray-200">💰 Jumlah</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-800 dark:text-gray-200">📌 Status</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-800 dark:text-gray-200">📅 Jatuh Tempo</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-800 dark:text-gray-200">⚙ Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr class="text-center hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200">{{ $payment->title }}</td>
                    <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-800 dark:text-gray-200">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">
                        @if($payment->status === 'lunas')
                            <span class="inline-block px-3 py-1 rounded-full bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 text-xs font-semibold">✅ Lunas</span>
                        @elseif($payment->status === 'proses')
                            <span class="inline-block px-3 py-1 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 text-xs font-semibold">⏳ Menunggu Verifikasi</span>
                        @else
                            <span class="inline-block px-3 py-1 rounded-full bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 text-xs font-semibold">❌ Belum Bayar</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($payment->due_date)->translatedFormat('d F Y') }}</td>
                    <td class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex flex-col gap-2">
                            @if($payment->status === 'belum')
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('payments.midtrans', $payment->id) }}" 
                                       class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded transition text-sm">
                                        <span>💳</span>
                                        Bayar Sekarang
                                    </a>
                                    
                                    <button @click="showUploadForm = !showUploadForm" 
                                            class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded transition text-sm">
                                        <span>📤</span>
                                        Upload Bukti Manual
                                    </button>

                                    <div x-show="showUploadForm" x-transition class="mt-3 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <form action="{{ route('user.payments.upload', $payment->id) }}" 
                                              method="POST" 
                                              enctype="multipart/form-data"
                                              @submit="loading = true">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="proof_{{ $payment->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    📎 Pilih File Bukti Transfer
                                                </label>
                                                <input type="file" 
                                                       name="proof" 
                                                       id="proof_{{ $payment->id }}" 
                                                       accept="image/*,.pdf"
                                                       required
                                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                                            </div>
                                            <button type="submit"
                                                    class="w-full inline-flex items-center justify-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold px-4 py-2 rounded transition text-sm disabled:opacity-60"
                                                    :disabled="loading">
                                                <svg x-show="loading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                                </svg>
                                                <span x-show="!loading">📤 Upload Bukti</span>
                                                <span x-show="loading">Memproses...</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @elseif($payment->status === 'proses')
                                <span class="text-yellow-600 dark:text-yellow-400 font-medium">⏳ Menunggu verifikasi admin</span>
                            @elseif($payment->status === 'lunas')
                                <span class="text-green-600 dark:text-green-400 font-medium">✅ Sudah Lunas</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-400 dark:text-gray-500">
                        <div class="flex flex-col items-center gap-2">
                            <span class="text-4xl">📄</span>
                            <span>Belum ada data pembayaran</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
