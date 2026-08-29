@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Daftar Pengaduan Warga</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Kelola dan pantau status pengaduan warga</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Daftar Pengaduan</h2>
            @if(auth()->user()->role === 'warga')
                <a href="{{ route('complaints.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Buat Laporan Baru</span>
                </a>
            @endif
        </div>

        <!-- Filter Section -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
            <form method="GET" action="{{ request()->url() }}" id="filter-form" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">🔍 Pencarian</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Judul atau isi pengaduan..."
                           class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-600 dark:text-white dark:border-gray-500">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📌 Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-600 dark:text-white dark:border-gray-500">
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
                    <a href="{{ request()->url() }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                        🔄 Reset
                    </a>
                </div>
                
                <!-- Sorting -->
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Urutkan:</span>
                    <a href="{{ request()->fullUrlWithQuery(array_merge(request()->all(), ['sort' => 'created_at', 'direction' => $direction === 'asc' ? 'desc' : 'asc'])) }}" 
                       class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        Tanggal {!! $sort === 'created_at' ? ($direction === 'asc' ? '↑' : '↓') : '' !!}
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(array_merge(request()->all(), ['sort' => 'judul', 'direction' => $direction === 'asc' ? 'desc' : 'asc'])) }}" 
                       class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        Judul {!! $sort === 'judul' ? ($direction === 'asc' ? '↑' : '↓') : '' !!}
                    </a>
                </div>
            </div>
        </div>

        @if($complaints->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada pengaduan</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mulai dengan membuat laporan pengaduan baru.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($complaints as $complaint)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $complaint->judul }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    @if($complaint->status == 'Selesai')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Selesai
                                        </span>
                                    @elseif($complaint->status == 'Diproses')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Diproses
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            Diterima
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($complaint->created_at)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @php
                                        $user = auth()->user();
                                        if ($user->role === 'warga') {
                                            $detailUrl = url('complaints/' . $complaint->id);
                                        } elseif ($user->role === 'rt') {
                                            $detailUrl = url('rt/complaints/' . $complaint->id);
                                        } else {
                                            $detailUrl = route('complaints.show', $complaint->id);
                                        }
                                    @endphp
                                    <a href="{{ $detailUrl }}" 
                                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Detail
                                    </a>
                                    @if(auth()->user()->role === 'rt')
                                        <a href="{{ route('complaints.edit', $complaint->id) }}" 
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors ml-2">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Tanggapi
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
