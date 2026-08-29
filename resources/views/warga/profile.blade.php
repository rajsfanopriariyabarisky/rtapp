@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Profil Saya</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Kelola data akun dan lihat riwayat aktivitas Anda</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profil Card -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="text-center mb-6">
                    <div class="w-24 h-24 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa fa-user text-3xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $user->nama }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mt-2">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Status Akun:</span>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $user->status_akun == 'disetujui' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($user->status_akun) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Bergabung Sejak:</span>
                        <span class="text-gray-800 dark:text-white">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>

                <div class="mt-6 space-y-2">
                    <a href="{{ route('warga.profile.edit') }}" 
                       class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                        Edit Profil
                    </a>
                    <a href="{{ route('warga.profile.change-password') }}" 
                       class="block w-full bg-gray-600 hover:bg-gray-700 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                        Ganti Password
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistik dan Aktivitas -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Statistik Aktivitas -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Statistik Aktivitas</h3>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fa fa-envelope text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['total_surat'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Surat</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fa fa-check text-green-600 dark:text-green-400"></i>
                        </div>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['surat_disetujui'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Disetujui</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fa fa-comments text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['total_pengaduan'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pengaduan</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fa fa-money text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['total_pembayaran'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pembayaran</p>
                    </div>
                </div>
            </div>

            <!-- Riwayat Aktivitas -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Riwayat Aktivitas Terbaru</h3>
                
                @if($recentActivities->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentActivities as $activity)
                            <div class="flex items-start space-x-3 p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fa {{ $activity['icon'] }} text-blue-600 dark:text-blue-400 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                                        {{ $activity['title'] }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                        {{ $activity['description'] }}
                                    </p>
                                    <div class="flex items-center justify-between mt-1">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $activity['date']->format('d/m/Y H:i') }}
                                        </span>
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $activity['status'] == 'Disetujui' || $activity['status'] == 'Selesai' ? 'bg-green-100 text-green-800' : 
                                               ($activity['status'] == 'Ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $activity['status'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fa fa-history text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 dark:text-gray-400">Belum ada aktivitas</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection