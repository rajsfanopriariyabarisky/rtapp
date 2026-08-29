@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100 py-8">
    <div class="w-full max-w-xl bg-white rounded-lg shadow-lg p-8">
        <h4 class="mb-8 text-2xl font-bold flex items-center gap-2">🧾 Buat Tagihan Baru</h4>

        <form action="{{ route('payments.store') }}" method="POST" x-data>
            @csrf

            {{-- Pilih Warga --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">👤 Pilih Warga</label>
                <select name="user_id" class="block w-full rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 text-gray-700" required>
                    <option value="">-- Pilih Warga --</option>
                    @foreach(\App\Models\User::where('role', 'warga')->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->nama }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Judul Tagihan --}}
            <div class="mb-6">
                <label for="title" class="block text-gray-700 font-semibold mb-2">🏷 Jenis Tagihan</label>
                <select name="title" id="title" class="block w-full rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 text-gray-700" required>
                    <option value="">-- Pilih Tagihan --</option>
                    <option value="Uang Keamanan">Uang Keamanan</option>
                    <option value="Iuran Sampah">Iuran Sampah</option>
                    <option value="Dana Sosial">Dana Sosial</option>
                    <option value="Kas RT">Kas RT</option>
                    <option value="Kerja Bakti">Kerja Bakti</option>
                </select>
            </div>

            {{-- Jumlah --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">💵 Jumlah (Rp)</label>
                <input 
                    type="number" 
                    name="amount" 
                    class="block w-full rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 text-gray-700" 
                    placeholder="Contoh: 50000" 
                    required
                    x-model="amount"
                >
            </div>

            {{-- Jatuh Tempo --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">📅 Jatuh Tempo</label>
                <div class="relative">
                    <input 
                        type="date" 
                        name="due_date" 
                        class="block w-full rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 pr-10 text-gray-700" 
                        required
                        x-model="due_date"
                    >
                    <button type="button" onclick="this.previousElementSibling.showPicker()" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 cursor-pointer">
                        📅
                    </button>
                </div>
            </div>

            <div class="mt-8">
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow transition duration-150 flex items-center justify-center gap-2"
                    x-on:click="$el.disabled = true; $el.innerHTML = '⏳ Menyimpan...'; $el.form.submit();"
                >
                    💾 Simpan Tagihan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection