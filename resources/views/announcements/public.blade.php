@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto my-10 px-4">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">📢 Pengumuman Publik</h2>
        <p class="text-gray-600 dark:text-gray-400">Informasi terbaru dari pengurus RT</p>
    </div>

    @if($announcements->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($announcements as $a)
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white line-clamp-2">{{ $a->title }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                📢
                            </span>
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <i class="fa fa-calendar mr-2"></i>
                            <span>{{ $a->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                        
                        <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed mb-4">
                            {{ $a->content }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-8 max-w-md mx-auto">
                <div class="text-6xl mb-4">📢</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Tidak Ada Pengumuman</h3>
                <p class="text-gray-600 dark:text-gray-400">Belum ada pengumuman publik saat ini. Silakan cek kembali nanti.</p>
            </div>
        </div>
    @endif
</div>
@endsection