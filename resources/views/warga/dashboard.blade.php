@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard Warga</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Selamat datang, {{ auth()->user()->nama }}!</p>
    </div>

    {{-- Ringkasan Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Surat Diajukan</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $jumlahSurat ?? 0 }}</p>
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
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Anggota Keluarga</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $jumlahKeluarga ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengaduan</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $jumlahPengaduan ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Edit Data Diri</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Perbarui informasi data diri Anda</p>
            <a href="{{ route('residents.edit-warga') }}" 
               class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                Edit Data Diri
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Kelola Data Keluarga</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Tambah dan kelola data anggota keluarga Anda</p>
            <div class="space-y-2">
                <a href="{{ route('warga.family.index') }}" 
                   class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                    Lihat Data Keluarga
                </a>
                <a href="{{ route('warga.family.create') }}" 
                   class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                    Tambah Anggota Keluarga
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Ajukan Surat</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Buat pengajuan surat pengantar untuk keperluan administrasi</p>
            <a href="{{ route('letters.create') }}" 
               class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                Buat Surat Pengantar
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Buat Pengaduan</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Laporkan masalah atau keluhan kepada RT/RW</p>
            <a href="{{ route('complaints.create') }}" 
               class="block w-full bg-red-600 hover:bg-red-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                Buat Pengaduan
            </a>
        </div>
    </div>

    {{-- Data Keluarga Terbaru --}}
    @if(isset($familyMembers) && $familyMembers->count() > 0)
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Anggota Keluarga Terbaru</h3>
            <a href="{{ route('warga.family.index') }}" 
               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
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
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($familyMembers->take(5) as $member)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            {{ $member->nama_lengkap }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $member->nik }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $member->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $member->status_tinggal == 'Tetap' ? 'bg-green-100 text-green-800' : 
                                   ($member->status_tinggal == 'Pindah' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $member->status_tinggal }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Surat Terbaru --}}
    @if(isset($letters) && $letters->count() > 0)
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Surat Terbaru</h3>
            <a href="{{ route('warga.letters.index') }}" 
               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                Lihat Semua
            </a>
        </div>
        
        <div class="space-y-4">
            @foreach($letters->take(3) as $letter)
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $letter->jenis_surat }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $letter->keterangan }}</p>
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
@endsection
