@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard Admin</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Selamat datang, {{ auth()->user()->nama }}! Kelola sistem pengguna RT/RW.</p>
    </div>

    {{-- Ringkasan Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengguna</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalUsers }}</p>
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
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Menunggu Persetujuan</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $pendingUsers }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Akun Disetujui</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $approvedUsers }}</p>
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
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $usersThisMonth }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Detail --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {{-- Statistik Pengguna --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                Statistik Pengguna
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Menunggu</span>
                    <span class="text-sm font-semibold text-yellow-600">{{ $pendingUsers }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Disetujui</span>
                    <span class="text-sm font-semibold text-green-600">{{ $approvedUsers }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Ditolak</span>
                    <span class="text-sm font-semibold text-red-600">{{ $rejectedUsers }}</span>
                </div>
            </div>
        </div>

        {{-- Persentase Status --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Persentase Status
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Disetujui</span>
                    <span class="text-sm font-semibold text-green-600">{{ $totalUsers > 0 ? round(($approvedUsers / $totalUsers) * 100, 1) : 0 }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Menunggu</span>
                    <span class="text-sm font-semibold text-yellow-600">{{ $totalUsers > 0 ? round(($pendingUsers / $totalUsers) * 100, 1) : 0 }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Ditolak</span>
                    <span class="text-sm font-semibold text-red-600">{{ $totalUsers > 0 ? round(($rejectedUsers / $totalUsers) * 100, 1) : 0 }}%</span>
                </div>
            </div>
        </div>

        {{-- Aktivitas Bulan Ini --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                Aktivitas Bulan Ini
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Pengguna Baru</span>
                    <span class="text-sm font-semibold text-blue-600">{{ $usersThisMonth }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total Akun</span>
                    <span class="text-sm font-semibold text-green-600">{{ $totalUsers }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Rata-rata/Bulan</span>
                    <span class="text-sm font-semibold text-purple-600">{{ $usersThisMonth > 0 ? round($totalUsers / max($usersThisMonth, 1), 1) : 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Kelola Akun Pending</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Persetujui atau tolak akun yang menunggu</p>
            <div class="space-y-2">
                <a href="{{ route('users.pending') }}" 
                   class="block w-full bg-yellow-600 hover:bg-yellow-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                    Lihat Akun Pending
                </a>
                @if($pendingUsers > 0)
                <div class="text-center">
                    <span class="text-sm text-yellow-600 font-semibold">{{ $pendingUsers }} akun menunggu</span>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Kelola Akun Aktif</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Lihat dan edit akun yang sudah aktif</p>
            <div class="space-y-2">
                <a href="{{ route('users.active') }}" 
                   class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                    Lihat Akun Aktif
                </a>
                <div class="text-center">
                    <span class="text-sm text-green-600 font-semibold">{{ $approvedUsers }} akun aktif</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Export Data</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Export data pengguna dalam berbagai format</p>
            <div class="space-y-2">
                <a href="{{ route('users.export.excel') }}" 
                   class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                    Export Excel
                </a>
                <a href="{{ route('users.export.pdf') }}" 
                   class="block w-full bg-red-600 hover:bg-red-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                    Export PDF
                </a>
            </div>
        </div>
    </div>

    {{-- Pengguna Terbaru --}}
    @if($recentUsers->count() > 0)
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Pengguna Terbaru</h3>
            <a href="{{ route('users.active') }}" 
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
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Tanggal Daftar
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentUsers->take(5) as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            {{ $user->nama }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                   ($user->role == 'rt' ? 'bg-blue-100 text-blue-800' : 
                                   ($user->role == 'rw' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800')) }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->status_akun == 'disetujui' ? 'bg-green-100 text-green-800' : 
                                   ($user->status_akun == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($user->status_akun) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->created_at->format('d/m/Y H:i') }}
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