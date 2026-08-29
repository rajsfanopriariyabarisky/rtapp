@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 p-8 mt-10 mb-10 rounded-2xl shadow-lg">
    <h2 class="text-3xl font-extrabold mb-8 text-gray-800 dark:text-white text-center">Tanggapi Pengaduan</h2>
    <form 
        method="POST" 
        action="{{ route('complaints.update', $complaint->id) }}"
        x-data="{
            status: '{{ old('status', $complaint->status) }}',
            tanggapan: `{{ old('tanggapan', $complaint->tanggapan) }}`
        }"
        class="space-y-7"
    >
        @csrf
        @method('PUT')

        <div>
            <label for="status" class="block text-base font-semibold text-gray-700 dark:text-gray-200 mb-2">
                Status
            </label>
            <select 
                x-model="status"
                name="status" 
                id="status"
                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white transition @error('status') border-red-500 ring-2 ring-red-300 @enderror"
                required
            >
                <option value="Diproses" :selected="status === 'Diproses'">Diproses</option>
                <option value="Selesai" :selected="status === 'Selesai'">Selesai</option>
                <option value="Ditolak" :selected="status === 'Diterima'">Diterima</option>
            </select>
            @error('status') 
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p> 
            @enderror
        </div>

        <div>
            <label for="tanggapan" class="block text-base font-semibold text-gray-700 dark:text-gray-200 mb-2">
                Tanggapan (Opsional)
            </label>
            <textarea 
                x-model="tanggapan"
                name="tanggapan" 
                id="tanggapan"
                rows="4"
                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-white transition @error('tanggapan') border-red-500 ring-2 ring-red-300 @enderror"
                placeholder="Tuliskan tanggapan Anda (jika ada)"
            >{{ old('tanggapan', $complaint->tanggapan) }}</textarea>
            @error('tanggapan') 
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p> 
            @enderror
        </div>

        <div class="flex justify-end">
            <button 
                type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
