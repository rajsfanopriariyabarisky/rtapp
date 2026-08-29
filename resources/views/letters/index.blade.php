@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-10 px-4 py-8 bg-white dark:bg-gray-900 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6 text-purple-700 dark:text-purple-400 flex items-center gap-2">
        <span>📄</span> Daftar Surat Pengantar
    </h1>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-800 dark:text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header & Actions -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
        <div class="mb-4 lg:mb-0">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Daftar Surat</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola surat pengantar warga dengan mudah</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('letters.index') }}" id="filter-form" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">🔍 Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Nama pemohon..."
                       class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
            </div>

            <!-- Jenis Surat -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📋 Jenis Surat</label>
                <select name="jenis_surat" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="all" {{ request('jenis_surat') == 'all' ? 'selected' : '' }}>Semua</option>
                    @foreach($jenisSuratList as $jenis)
                        <option value="{{ $jenis }}" {{ request('jenis_surat') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📌 Status</label>
                <select name="status" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                    @foreach($statusList as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal Mulai -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📅 Tanggal Mulai</label>
                <div class="relative">
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" 
                           class="w-full rounded-lg border-gray-300 px-3 py-2 pr-10 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <button type="button" onclick="this.previousElementSibling.showPicker()" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 cursor-pointer">
                        📅
                    </button>
                </div>
            </div>

            <!-- Tanggal Akhir -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📅 Tanggal Akhir</label>
                <div class="relative">
                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" 
                           class="w-full rounded-lg border-gray-300 px-3 py-2 pr-10 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <button type="button" onclick="this.previousElementSibling.showPicker()" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 cursor-pointer">
                        📅
                    </button>
                </div>
            </div>
        </form>

        <!-- Filter Actions -->
        <div class="flex justify-between items-center mt-4">
            <div class="flex gap-2">
                <button type="submit" form="filter-form" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                    🔍 Terapkan Filter
                </button>
                <a href="{{ route('letters.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                    🔄 Reset
                </a>
            </div>
            
            <!-- Sorting -->
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">Urutkan:</span>
                <a href="{{ route('letters.index', array_merge(request()->all(), ['sort' => 'tanggal_pengajuan', 'direction' => $direction === 'asc' ? 'desc' : 'asc'])) }}" 
                   class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    Tanggal {!! $sort === 'tanggal_pengajuan' ? ($direction === 'asc' ? '↑' : '↓') : '' !!}
                </a>
                <a href="{{ route('letters.index', array_merge(request()->all(), ['sort' => 'jenis_surat', 'direction' => $direction === 'asc' ? 'desc' : 'asc'])) }}" 
                   class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    Jenis Surat {!! $sort === 'jenis_surat' ? ($direction === 'asc' ? '↑' : '↓') : '' !!}
                </a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">👤 Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">📋 Jenis Surat</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">📌 Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">📅 Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">⚙️ Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($letters as $letter)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $letter->resident->nama_lengkap ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $letter->jenis_surat }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $letter->status === 'Disetujui' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                               ($letter->status === 'Ditolak' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 
                                'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300') }}">
                            {{ ucfirst($letter->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                        {{ \Carbon\Carbon::parse($letter->tanggal_pengajuan)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('letters.show', $letter->id) }}"
                               class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium transition duration-200">
                                <span>👁️</span>
                                Detail
                            </a>
                            @if ($letter->file_surat)
                                <a href="{{ asset('storage/' . $letter->file_surat) }}" target="_blank"
                                   class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition duration-200">
                                    <span>📥</span>
                                    Download
                                </a>
                            @else
                                <span class="inline-flex items-center gap-1 text-gray-400 dark:text-gray-500 font-medium">
                                    <span>📄</span>
                                    Belum tersedia
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-3 text-gray-400 dark:text-gray-500">
                            <span class="text-4xl">📄</span>
                            <span class="text-lg font-medium">Belum ada surat pengantar</span>
                            <p class="text-sm">Mulai dengan membuat surat pengantar baru</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
