@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Detail Pengaduan</h2>

    <div class="mb-6 p-5 rounded-lg border bg-gray-50 dark:bg-gray-800">
        <div class="flex items-center justify-between mb-2">
            
            <span class="text-xl font-semibold text-gray-900 dark:text-white">{{ $complaint->judul }}</span>
            @if($complaint->status == 'Selesai')
                <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Selesai</span>
            @elseif($complaint->status == 'Diproses')
                <span class="inline-block px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">Diproses</span>
            @else
                <span class="inline-block px-3 py-1 text-xs font-semibold bg-gray-200 text-gray-700 rounded-full">Diterima</span>
            @endif
        </div>
        <p class="mb-4 text-gray-700 dark:text-gray-200">{{ $complaint->isi }}</p>

        @if ($complaint->foto)
            <div class="mb-4">
                <p class="font-medium text-gray-700 dark:text-gray-300 mb-1">Foto:</p>
                <img src="{{ asset('storage/' . $complaint->foto) }}" alt="Foto Laporan" class="rounded shadow max-w-full h-auto" style="max-width: 350px;">
            </div>
        @endif

        @if ($complaint->tanggapan)
            <hr class="my-4 border-gray-200 dark:border-gray-700">
            <h5 class="font-semibold text-gray-800 dark:text-white mb-1">Tanggapan RT/RW:</h5>
            <p class="mb-1 text-gray-700 dark:text-gray-200">{{ $complaint->tanggapan }}</p>
            <p class="text-xs text-gray-500">
                Ditanggapi oleh: {{ $complaint->ditanggapioleh->nama ?? '-' }} 
                pada {{ $complaint->tanggal_tanggapan ? \Carbon\Carbon::parse($complaint->tanggal_tanggapan)->format('d M Y H:i') : '-' }}
        @endif
    </div>

    
</div>
@endsection
