@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-12 px-6 py-8 bg-white rounded-xl shadow" x-data="{ loading: false }">
    <h2 class="text-2xl font-bold text-center mb-6 text-yellow-700 flex items-center justify-center gap-2">
        <span>✏</span> Edit Tagihan Warga
    </h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <strong>Terjadi kesalahan:</strong>
            <ul class="list-disc pl-5 mt-2">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form 
        action="{{ route('payments.update', $payment->id) }}" 
        method="POST" 
        class="space-y-5"
        @submit="loading = true"
    >
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Tagihan</label>
            <select 
                name="title" 
                id="title" 
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 px-3 py-2"
                required
            >
                <option value="">-- Pilih Tagihan --</option>
                @foreach(['Uang Keamanan', 'Iuran Sampah', 'Dana Sosial', 'Kas RT', 'Kerja Bakti'] as $tagihan)
                    <option value="{{ $tagihan }}" {{ $payment->title === $tagihan ? 'selected' : '' }}>{{ $tagihan }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
            <input 
                type="number" 
                name="amount" 
                id="amount"
                min="0"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 px-3 py-2"
                value="{{ old('amount', $payment->amount) }}" 
                required
            >
        </div>

        <div>
            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Jatuh Tempo</label>
            <div class="relative">
                <input 
                    type="date" 
                    name="due_date" 
                    id="due_date"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 px-3 py-2 pr-10"
                    value="{{ old('due_date', date('Y-m-d', strtotime($payment->due_date))) }}" 
                    required
                >
                <button type="button" onclick="this.previousElementSibling.showPicker()" 
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 cursor-pointer">
                    📅
                </button>
            </div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <button 
                type="submit" 
                class="inline-flex items-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold px-6 py-2 rounded transition disabled:opacity-60"
                :disabled="loading"
            >
                <svg x-show="loading" class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                <span x-show="!loading">💾 Simpan Perubahan</span>
                <span x-show="loading">Menyimpan...</span>
            </button>
            <a 
                href="{{ route('payments.index') }}" 
                class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-2 rounded transition"
            >
                🔙 Batal
            </a>
        </div>
    </form>
</div>
@endsection