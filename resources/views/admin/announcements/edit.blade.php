@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 py-8 px-2">
    <div class="w-full max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-2 px-6 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 dark:from-yellow-700 dark:to-yellow-600">
                <i class="fa fa-bullhorn text-white text-xl"></i>
                <h4 class="text-white text-lg font-semibold">✏ Edit Pengumuman</h4>
            </div>
            <div class="px-8 py-6">
                <form method="POST" action="{{ route('announcements.update', $announcement->id) }}" autocomplete="off" x-data="{ isPublic: {{ $announcement->is_public ? 'true' : 'false' }} }">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="title" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                            Judul Pengumuman <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            required 
                            value="{{ old('title', $announcement->title) }}"
                            placeholder="Masukkan judul pengumuman"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition"
                        >
                    </div>

                    <div class="mb-6">
                        <label for="content" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                            Isi Pengumuman <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="content" 
                            id="content" 
                            rows="6" 
                            required 
                            placeholder="Tulis isi pengumuman di sini..."
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition resize-none"
                        >{{ old('content', $announcement->content) }}</textarea>
                    </div>

                    <div class="flex items-center mb-6">
                        <input type="hidden" name="is_public" value="0">
                        <input 
                            type="checkbox" 
                            name="is_public" 
                            value="1" 
                            id="is_public"
                            x-model="isPublic"
                            :checked="isPublic"
                            class="form-checkbox h-5 w-5 text-yellow-500 dark:text-yellow-400 border-gray-300 dark:border-gray-600 focus:ring-yellow-500 transition"
                        >
                        <label for="is_public" class="ml-3 text-gray-600 dark:text-gray-300 select-none cursor-pointer">
                            Tampilkan ke publik
                        </label>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 justify-between items-center mt-8">
                        <button 
                            type="submit" 
                            class="w-full sm:w-auto flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-green-400 dark:bg-green-500 dark:hover:bg-green-600"
                        >
                            <i class="fa fa-save"></i> Simpan Perubahan
                        </button>
                        <a 
                            href="{{ route('announcements.index') }}" 
                            class="w-full sm:w-auto flex items-center justify-center gap-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold px-6 py-3 rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        >
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection