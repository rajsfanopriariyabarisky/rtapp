@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Buat Pengaduan Baru</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Isi formulir di bawah untuk membuat laporan pengaduan baru</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Formulir Pengaduan</h2>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 rounded-lg text-red-800">
                {{ $errors->first() }}
            </div>
        @endif

        <form 
            method="POST" 
            action="{{ route('complaints.store') }}" 
            enctype="multipart/form-data"
            x-data="{
                judul: '{{ old('judul') }}',
                isi: `{{ old('isi') }}`,
                fotoName: '',
                updateFotoName(e) { this.fotoName = e.target.files.length ? e.target.files[0].name : '' }
            }"
            class="space-y-6"
        >
            @csrf

            <div>
                <label for="judul" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input 
                    x-model="judul"
                    type="text" 
                    name="judul" 
                    id="judul"
                    required 
                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors @error('judul') border-red-500 ring-2 ring-red-300 @enderror"
                    placeholder="Masukkan judul pengaduan"
                >
                @error('judul') 
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label for="isi" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Isi Laporan <span class="text-red-500">*</span>
                </label>
                <textarea 
                    x-model="isi"
                    name="isi" 
                    id="isi"
                    required 
                    rows="5"
                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors resize-none @error('isi') border-red-500 ring-2 ring-red-300 @enderror"
                    placeholder="Tuliskan isi laporan Anda"
                >{{ old('isi') }}</textarea>
                @error('isi') 
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label for="foto" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Foto (opsional)
                </label>
                <div class="flex items-center gap-4">
                    <label class="flex items-center px-4 py-2 bg-blue-50 dark:bg-gray-700 text-blue-700 dark:text-blue-200 rounded-lg cursor-pointer border border-blue-200 dark:border-gray-600 hover:bg-blue-100 dark:hover:bg-gray-600 transition">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                        <span>Pilih Foto</span>
                        <input 
                            type="file" 
                            name="foto" 
                            id="foto"
                            accept="image/*"
                            class="hidden"
                            @change="updateFotoName"
                        >
                    </label>
                    <span class="text-sm text-gray-600 dark:text-gray-300" x-text="fotoName"></span>
                </div>
                @error('foto') 
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p> 
                @enderror
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="text-red-500">*</span> Wajib diisi
                </p>
                <div class="flex space-x-3">
                    <a href="{{ url('complaints') }}" 
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Batal
                    </a>
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                        x-bind:disabled="!judul || !isi"
                        :class="(!judul || !isi) ? 'opacity-50 cursor-not-allowed' : ''"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Kirim Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
