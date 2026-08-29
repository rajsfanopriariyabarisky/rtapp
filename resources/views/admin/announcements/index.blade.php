@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100 flex items-center gap-2">
            <i class="fa fa-bullhorn text-blue-600 dark:text-blue-400"></i> Daftar Pengumuman
        </h1>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 border border-green-300 dark:bg-green-900 dark:text-green-200 dark:border-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tombol Tambah --}}
        <div class="mb-6 flex justify-end">
            <a href="{{ route('announcements.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-blue-400">
                <i class="fa fa-plus"></i> Buat Pengumuman
            </a>
        </div>

        @if($announcements->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($announcements as $a)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ $a->title }}</h2>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <span>{{ $a->created_at->format('d M Y') }}</span>
                            @if($a->is_public)
                                <span class="ml-3 px-2 py-0.5 rounded bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 text-xs font-medium">Publik</span>
                            @else
                                <span class="ml-3 px-2 py-0.5 rounded bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300 text-xs font-medium">Privat</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('announcements.edit', $a->id) }}"
                           class="inline-flex items-center gap-1 px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded transition focus:outline-none focus:ring-2 focus:ring-yellow-300">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <form 
                            x-data 
                            action="{{ route('announcements.destroy', $a->id) }}" 
                            method="POST" 
                            @submit.prevent="if(confirm('Hapus pengumuman ini?')) $el.submit()"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded transition focus:outline-none focus:ring-2 focus:ring-red-400">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="px-4 py-4 rounded bg-blue-100 text-blue-800 border border-blue-300 dark:bg-blue-900 dark:text-blue-200 dark:border-blue-700 mt-6">
                Belum ada pengumuman.
            </div>
        @endif
    </div>
</div>
@endsection