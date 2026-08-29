@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-10 px-4 py-8 bg-white dark:bg-gray-900 rounded-xl shadow" x-data="{ showConfirm: false, deleteUrl: '' }">
    <h1 class="text-2xl font-bold mb-6 text-blue-700 dark:text-blue-400 flex items-center gap-2">
        <span>👥</span> Data Warga
    </h1>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-800 dark:text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header & Actions -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
        <div class="mb-4 lg:mb-0">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Daftar Warga</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola data warga dengan mudah</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <form action="{{ route('residents.import.excel') }}" method="POST" enctype="multipart/form-data" class="flex gap-2 items-center">
                @csrf
                <input type="file" name="file" accept=".xlsx,.xls" class="text-sm text-gray-600 border border-gray-300 rounded-lg px-3 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center gap-2">
                    <span>📥</span>
                    Import Excel
                </button>
            </form>
            <a href="{{ route('residents.export.excel') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center justify-center gap-2">
                <span>📤</span>
                Export Excel
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('residents.index') }}" id="filter-form" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">🔍 Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Nama, NIK, Alamat, Telepon..."
                       class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">⚧ Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="all" {{ request('jenis_kelamin') == 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Agama -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">🕊️ Agama</label>
                <select name="agama" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="all" {{ request('agama') == 'all' ? 'selected' : '' }}>Semua</option>
                    @foreach($agamaList as $agama)
                        <option value="{{ $agama }}" {{ request('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Tinggal -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">🏠 Status Tinggal</label>
                <select name="status_tinggal" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="all" {{ request('status_tinggal') == 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="Tetap" {{ request('status_tinggal') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="Pindah" {{ request('status_tinggal') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                    <option value="Meninggal" {{ request('status_tinggal') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                </select>
            </div>

            <!-- RT -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📍 RT</label>
                <select name="rt" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="all" {{ request('rt') == 'all' ? 'selected' : '' }}>Semua</option>
                    @foreach($rtList as $rt)
                        <option value="{{ $rt }}" {{ request('rt') == $rt ? 'selected' : '' }}>RT {{ $rt }}</option>
                    @endforeach
                </select>
            </div>

            <!-- RW -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📍 RW</label>
                <select name="rw" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="all" {{ request('rw') == 'all' ? 'selected' : '' }}>Semua</option>
                    @foreach($rwList as $rw)
                        <option value="{{ $rw }}" {{ request('rw') == $rw ? 'selected' : '' }}>RW {{ $rw }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        <!-- Filter Actions -->
        <div class="flex justify-between items-center mt-4">
            <div class="flex gap-2">
                <button type="submit" form="filter-form" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                    🔍 Terapkan Filter
                </button>
                <a href="{{ route('residents.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                    🔄 Reset
                </a>
            </div>
            
            <!-- Sorting -->
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">Urutkan:</span>
                <a href="{{ route('residents.index', array_merge(request()->all(), ['sort' => 'nama_lengkap', 'direction' => $direction === 'asc' ? 'desc' : 'asc'])) }}" 
                   class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    Nama {!! $sort === 'nama_lengkap' ? ($direction === 'asc' ? '↑' : '↓') : '' !!}
                </a>
                <a href="{{ route('residents.index', array_merge(request()->all(), ['sort' => 'nik', 'direction' => $direction === 'asc' ? 'desc' : 'asc'])) }}" 
                   class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    NIK {!! $sort === 'nik' ? ($direction === 'asc' ? '↑' : '↓') : '' !!}
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
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">🆔 NIK</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">📍 Alamat</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">⚧ JK</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">🕊️ Agama</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">📞 Telepon</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">💼 Pekerjaan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">⚙️ Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($residents as $resident)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $resident->nama_lengkap }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 font-mono">{{ $resident->nik }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $resident->alamat }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $resident->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-300' }}">
                            {{ $resident->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                        @if($resident->agama)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                {{ $resident->agama }}
                            </span>
                        @else
                            <span class="text-gray-400 dark:text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $resident->telepon }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $resident->pekerjaan }}</td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('residents.edit', $resident->id) }}"
                               class="inline-flex items-center gap-1 text-yellow-600 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300 font-medium transition duration-200">
                                <span>✏️</span>
                                Edit
                            </a>
                            <button
                                @click="showConfirm = true; deleteUrl = '{{ route('residents.destroy', $resident) }}'"
                                class="inline-flex items-center gap-1 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium transition duration-200"
                            >
                                <span>🗑️</span>
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-3 text-gray-400 dark:text-gray-500">
                            <span class="text-4xl">📄</span>
                            <span class="text-lg font-medium">Belum ada data warga</span>
                            <p class="text-sm">Mulai dengan menambahkan data warga baru</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $residents->links() }}
    </div>

    <!-- Konfirmasi Modal Hapus -->
    <div x-show="showConfirm" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="showConfirm = false"
             class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-xl w-full max-w-md mx-4">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-2xl">⚠️</span>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Konfirmasi Hapus</h2>
            </div>
            <p class="text-gray-600 dark:text-gray-300 mb-6">Yakin ingin menghapus data warga ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-end gap-3">
                <button @click="showConfirm = false"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition duration-200">
                    Batal
                </button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition duration-200">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
