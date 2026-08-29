@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-10 px-4 py-8 bg-white dark:bg-gray-900 rounded-xl shadow" x-data="{ loading: false }">
    <h1 class="text-2xl font-bold mb-6 text-yellow-700 dark:text-yellow-400 flex items-center gap-2">
        <span>📄</span> Daftar Pembayaran Warga
    </h1>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-800 dark:text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header & Actions -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
        <div class="mb-4 lg:mb-0">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Daftar Pembayaran</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola pembayaran warga dengan mudah</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('payments.create') }}"
               class="inline-flex items-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold px-5 py-2 rounded transition shadow">
                <span>➕</span>
                Buat Tagihan Baru
            </a>
            <a href="{{ route('admin.payments.paymentReport') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded transition shadow">
                <span>📊</span>
                Laporan Pembayaran
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('payments.index') }}" id="filter-form" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">🔍 Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Nama warga..."
                       class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
            </div>

            <!-- Judul Tagihan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">🏷️ Judul Tagihan</label>
                <select name="title" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="all" {{ request('title') == 'all' ? 'selected' : '' }}>Semua</option>
                    @foreach($titleList as $title)
                        <option value="{{ $title }}" {{ request('title') == $title ? 'selected' : '' }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📌 Status</label>
                <select name="status" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                    @foreach($statusList as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            @if($status == 'belum') Belum Bayar
                            @elseif($status == 'proses') Menunggu Verifikasi
                            @else Lunas
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Due Date Mulai -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📅 Due Date Mulai</label>
                <div class="relative">
                    <input type="date" name="due_date_mulai" value="{{ request('due_date_mulai') }}" 
                           class="w-full rounded-lg border-gray-300 px-3 py-2 pr-10 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <button type="button" onclick="this.previousElementSibling.showPicker()" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 cursor-pointer">
                        📅
                    </button>
                </div>
            </div>

            <!-- Due Date Akhir -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📅 Due Date Akhir</label>
                <div class="relative">
                    <input type="date" name="due_date_akhir" value="{{ request('due_date_akhir') }}" 
                           class="w-full rounded-lg border-gray-300 px-3 py-2 pr-10 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <button type="button" onclick="this.previousElementSibling.showPicker()" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 cursor-pointer">
                        📅
                    </button>
                </div>
            </div>

            <!-- Range Nominal -->
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">💰 Min</label>
                    <input type="number" name="amount_min" value="{{ request('amount_min') }}" 
                           placeholder="Minimal"
                           class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">💰 Max</label>
                    <input type="number" name="amount_max" value="{{ request('amount_max') }}" 
                           placeholder="Maksimal"
                           class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
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
                <a href="{{ route('payments.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                    🔄 Reset
                </a>
            </div>
            
            <!-- Sorting -->
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">Urutkan:</span>
                <a href="{{ route('payments.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => $direction === 'asc' ? 'desc' : 'asc'])) }}" 
                   class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    Tanggal {!! $sort === 'created_at' ? ($direction === 'asc' ? '↑' : '↓') : '' !!}
                </a>
                <a href="{{ route('payments.index', array_merge(request()->all(), ['sort' => 'amount', 'direction' => $direction === 'asc' ? 'desc' : 'asc'])) }}" 
                   class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    Nominal {!! $sort === 'amount' ? ($direction === 'asc' ? '↑' : '↓') : '' !!}
                </a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-center">
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-800 dark:text-white">👤 Nama Warga</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-800 dark:text-white">🏷 Judul</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-800 dark:text-white">💰 Jumlah</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-800 dark:text-white">📌 Status</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-800 dark:text-white">📅 Jatuh Tempo</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-800 dark:text-white">🖼 Bukti</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-800 dark:text-white">⚙ Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr class="text-center hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <td class="py-2 px-4 text-gray-800 dark:text-white">{{ $payment->user->nama }}</td>
                    <td class="py-2 px-4 text-gray-800 dark:text-white">{{ $payment->title }}</td>
                    <td class="py-2 px-4 text-gray-800 dark:text-white">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td class="py-2 px-4">
                        @if($payment->status === 'belum')
                            <span class="inline-block px-3 py-1 rounded-full bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 text-xs font-semibold">Belum Bayar</span>
                        @elseif($payment->status === 'proses')
                            <span class="inline-block px-3 py-1 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300 text-xs font-semibold">Menunggu Verifikasi</span>
                        @else
                            <span class="inline-block px-3 py-1 rounded-full bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 text-xs font-semibold">Lunas</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 text-gray-800 dark:text-white">{{ \Carbon\Carbon::parse($payment->due_date)->translatedFormat('d F Y') }}</td>
                    <td class="py-2 px-4">
                        @if($payment->proof)
                            <a href="{{ asset('storage/' . $payment->proof) }}"
                               class="inline-flex items-center gap-1 bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 font-semibold px-3 py-1 rounded transition text-xs"
                               target="_blank">
                                Lihat
                            </a>
                        @else
                            <span class="text-gray-400 dark:text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="py-2 px-4">
                        <div class="flex flex-wrap gap-2 justify-center">
                            @if($payment->status === 'proses')
                            <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST"
                                  @submit="loading = true; return confirm('Verifikasi sebagai lunas?')">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white font-semibold px-3 py-1 rounded transition text-xs disabled:opacity-60"
                                    :disabled="loading">
                                    <svg x-show="loading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                    </svg>
                                    <span x-show="!loading">Verifikasi</span>
                                    <span x-show="loading">Memproses...</span>
                                </button>
                            </form>
                            @endif

                            @if($payment->status !== 'lunas')
                            <a href="{{ route('payments.edit', $payment->id) }}"
                               class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-3 py-1 rounded transition text-xs">
                                Edit
                            </a>
                            @endif

                            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST"
                                  @submit="return confirm('Yakin ingin menghapus tagihan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white font-semibold px-3 py-1 rounded transition text-xs">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center">
                        <div class="flex flex-col items-center gap-3 text-gray-400 dark:text-gray-500">
                            <span class="text-4xl">📄</span>
                            <span class="text-lg font-medium">Belum ada data pembayaran</span>
                            <p class="text-sm">Mulai dengan membuat tagihan baru</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection