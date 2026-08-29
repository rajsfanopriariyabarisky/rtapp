@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard RT</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Selamat datang, {{ auth()->user()->nama }}! Kelola data warga dan layanan RT Anda.</p>
    </div>

    {{-- Ringkasan Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengaduan</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalComplaints }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Surat</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalLetters }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Warga</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalResidents }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Bulan Ini</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $complaintsThisMonth + $lettersThisMonth }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Detail --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {{-- Statistik Pengaduan --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                Statistik Pengaduan
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Menunggu</span>
                    <span class="text-sm font-semibold text-yellow-600">{{ $pendingComplaints }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Diproses</span>
                    <span class="text-sm font-semibold text-blue-600">{{ $processingComplaints }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Selesai</span>
                    <span class="text-sm font-semibold text-green-600">{{ $completedComplaints }}</span>
                </div>
            </div>
        </div>

        {{-- Statistik Surat --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Statistik Surat
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Menunggu</span>
                    <span class="text-sm font-semibold text-yellow-600">{{ $pendingLetters }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Disetujui</span>
                    <span class="text-sm font-semibold text-green-600">{{ $approvedLetters }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Ditolak</span>
                    <span class="text-sm font-semibold text-red-600">{{ $rejectedLetters }}</span>
                </div>
            </div>
        </div>

        {{-- Statistik Warga --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Statistik Warga
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Laki-laki</span>
                    <span class="text-sm font-semibold text-blue-600">{{ $maleResidents }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Perempuan</span>
                    <span class="text-sm font-semibold text-pink-600">{{ $femaleResidents }}</span>
                </div>
                <div class="flex justify-between items-center border-t pt-2">
                    <span class="text-sm font-medium text-gray-800 dark:text-white">Total</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $totalResidents }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Kelola Pengaduan</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Tanggapi dan kelola pengaduan dari warga</p>
            <div class="space-y-2">
                <a href="{{ url('rt/complaints') }}" 
                   class="block w-full bg-red-600 hover:bg-red-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                    Lihat Semua Pengaduan
                </a>
                <a href="{{ url('rt/complaints/create') }}" 
                   class="block w-full bg-orange-600 hover:bg-orange-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                    Buat Pengaduan Baru
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Kelola Surat</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Proses dan kelola pengajuan surat warga</p>
            <div class="space-y-2">
                <a href="{{ route('letters.index') }}" 
                   class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                    Lihat Semua Surat
                </a>
                <a href="{{ route('letters.create') }}" 
                   class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                    Buat Surat Baru
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Data Warga</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Kelola dan lihat data warga RT</p>
            <div class="space-y-2">
                <a href="{{ route('residents.index') }}" 
                   class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                    Lihat Data Warga
                </a>
                <a href="{{ route('residents.create') }}" 
                   class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                    Tambah Warga Baru
                </a>
            </div>
        </div>
    </div>

    {{-- Data Terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Pengaduan Terbaru --}}
        @if($recentComplaints->count() > 0)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Pengaduan Terbaru</h3>
                <a href="{{ url('rt/complaints') }}" 
                   class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                    Lihat Semua
                </a>
            </div>
            
            <div class="space-y-4">
                @foreach($recentComplaints as $complaint)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $complaint->judul }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $complaint->resident->nama_lengkap ?? 'Warga' }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $complaint->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $complaint->status == 'Selesai' ? 'bg-green-100 text-green-800' : 
                               ($complaint->status == 'Diproses' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ $complaint->status }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Surat Terbaru --}}
        @if($recentLetters->count() > 0)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Surat Terbaru</h3>
                <a href="{{ route('letters.index') }}" 
                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                    Lihat Semua
                </a>
            </div>
            
            <div class="space-y-4">
                @foreach($recentLetters as $letter)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $letter->jenis_surat }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $letter->resident->nama_lengkap ?? 'Warga' }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $letter->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $letter->status == 'Disetujui' ? 'bg-green-100 text-green-800' : 
                               ($letter->status == 'Ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ $letter->status }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Warga Terbaru --}}
    @if($recentResidents->count() > 0)
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Warga Terbaru</h3>
            <a href="{{ route('residents.index') }}" 
               class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 text-sm font-medium">
                Lihat Semua
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Nama
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            NIK
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Jenis Kelamin
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Agama
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentResidents->take(5) as $resident)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            {{ $resident->nama_lengkap }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $resident->nik }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $resident->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $resident->agama ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $resident->status_tinggal == 'Tetap' ? 'bg-green-100 text-green-800' : 
                                   ($resident->status_tinggal == 'Pindah' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $resident->status_tinggal }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
