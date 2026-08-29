@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Ajukan Surat Pengantar</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Isi formulir di bawah untuk mengajukan surat pengantar baru</p>
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
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Formulir Pengajuan Surat</h2>
        </div>

        <form 
            action="{{ route('letters.store') }}" 
            method="POST" 
            x-data="{
                jenis_surat: '',
                keperluan: '',
                tanggal_pengajuan: ''
            }"
            class="space-y-6"
        >
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="jenis_surat" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Jenis Surat <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="jenis_surat"
                        name="jenis_surat" 
                        x-model="jenis_surat"
                        required 
                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors"
                    >
                        <option value="" disabled selected>Pilih jenis surat</option>
                        <option value="SKCK">SKCK</option>
                        <option value="Domisili">Domisili</option>
                        <option value="Usaha">Usaha</option>
                        <option value="Kematian">Kematian</option>
                    </select>
                </div>

                <div>
                    <label for="tanggal_pengajuan" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Tanggal Pengajuan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="date" 
                            id="tanggal_pengajuan"
                            name="tanggal_pengajuan" 
                            x-model="tanggal_pengajuan"
                            required 
                            class="block w-full px-3 py-2 pr-10 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors"
                        />
                        <button type="button" onclick="this.previousElementSibling.showPicker()" 
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 cursor-pointer">
                            📅
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <label for="keperluan" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Keperluan <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="keperluan"
                    name="keperluan" 
                    x-model="keperluan"
                    required 
                    rows="4"
                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors resize-none"
                    placeholder="Jelaskan keperluan pengajuan surat ini..."
                ></textarea>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="text-red-500">*</span> Wajib diisi
                </p>
                <div class="flex space-x-3">
                    <a href="{{ url('letters') }}" 
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Batal
                    </a>
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                        x-bind:disabled="!jenis_surat || !keperluan || !tanggal_pengajuan"
                        :class="(!jenis_surat || !keperluan || !tanggal_pengajuan) ? 'opacity-50 cursor-not-allowed' : ''"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Ajukan Surat
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
