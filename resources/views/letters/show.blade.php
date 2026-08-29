@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto my-10 bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-8 text-gray-800 dark:text-white text-center">Detail Surat Pengantar</h2>
    <div class="space-y-5">
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Nama</label>
            <input type="text" value="{{ $letter->resident?->nama_lengkap ?? '-' }}" readonly
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none" />
        </div>
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">NIK</label>
            <input type="text" value="{{ $letter->resident?->nik ?? '-' }}" readonly
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none" />
        </div>
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Alamat</label>
            <input type="text" value="{{ $letter->resident?->alamat ?? '-' }}" readonly
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none" />
        </div>
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Keperluan</label>
            <input type="text" value="{{ $letter->keperluan }}" readonly
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none" />
        </div>
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Tanggal Permohonan</label>
            <input type="text" value="{{ \Carbon\Carbon::parse($letter->tanggal_pengajuan)->translatedFormat('d M Y') }}" readonly
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none" />
        </div>
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Status</label>
            <input type="text" value="{{ ucfirst($letter->status) }}" readonly
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none
                @if($letter->status === 'Disetujui') border-green-500 text-green-600 @elseif($letter->status === 'Ditolak') border-red-500 text-red-600 @else border-gray-400 text-gray-600 @endif" />
        </div>
    </div>

    @if ($letter->status === 'Menunggu')
    <div class="mt-8 flex flex-col sm:flex-row gap-4" x-data="{ loading: false }">
        <form action="{{ route('letters.approve', $letter->id) }}" method="POST" x-on:submit="loading = true">
            @csrf
            <button type="submit"
                class="w-full sm:w-auto flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-green-400"
                x-bind:disabled="loading"
                x-bind:class="loading ? 'opacity-50 cursor-not-allowed' : ''">
                <span x-show="!loading"><i class="fa fa-check mr-2"></i>Setujui</span>
                <span x-show="loading" class="flex items-center"><svg class="animate-spin h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>Memproses...</span>
            </button>
        </form>
        <form action="{{ route('letters.reject', $letter->id) }}" method="POST" x-on:submit="loading = true">
            @csrf
            <button type="submit"
                class="w-full sm:w-auto flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-red-400"
                x-bind:disabled="loading"
                x-bind:class="loading ? 'opacity-50 cursor-not-allowed' : ''">
                <span x-show="!loading"><i class="fa fa-times mr-2"></i>Tolak</span>
                <span x-show="loading" class="flex items-center"><svg class="animate-spin h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>Memproses...</span>
            </button>
        </form>
    </div>
    @endif

    @if ($letter->status === 'Disetujui' && $letter->file_surat)
        <div class="mt-8">
            <a href="{{ asset('storage/' . $letter->file_surat) }}" target="_blank"
                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-blue-400">
                <i class="fa fa-download mr-2"></i> Unduh PDF Surat
            </a>
        </div>
    @endif
</div>
@endsection
