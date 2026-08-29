@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Lengkapi Data Diri Anda</h2>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('residents.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-medium mb-1">NIK</label>
            <input type="text" name="nik" value="{{ old('nik') }}" required class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('nik') border-red-500 @enderror">
            @error('nik') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('nama_lengkap') border-red-500 @enderror">
            @error('nama_lengkap') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('tempat_lahir') border-red-500 @enderror">
            @error('tempat_lahir') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-200 mb-1">Tanggal Lahir</label>
            <div class="relative">
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required 
                       class="w-full px-3 py-2 pr-10 border rounded dark:bg-gray-800 dark:text-white @error('tanggal_lahir') border-red-500 @enderror">
                <button type="button" onclick="this.previousElementSibling.showPicker()" 
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 cursor-pointer">
                    📅
                </button>
            </div>
            @error('tanggal_lahir') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" required class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('jenis_kelamin') border-red-500 @enderror">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Agama</label>
            <select name="agama" class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('agama') border-red-500 @enderror">
                <option value="">Pilih Agama</option>
                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                <option value="Lainnya" {{ old('agama') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            @error('agama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Alamat</label>
            <input type="text" name="alamat" value="{{ old('alamat') }}" required class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('alamat') border-red-500 @enderror">
            @error('alamat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">RT</label>
            <input type="text" name="rt" value="{{ old('rt') }}" required class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('rt') border-red-500 @enderror">
            @error('rt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">RW</label>
            <input type="text" name="rw" value="{{ old('rw') }}" required class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('rw') border-red-500 @enderror">
            @error('rw') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Telepon</label>
            <input type="text" name="telepon" value="{{ old('telepon') }}" required class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('telepon') border-red-500 @enderror">
            @error('telepon') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('email') border-red-500 @enderror">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Pekerjaan</label>
            <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('pekerjaan') border-red-500 @enderror">
            @error('pekerjaan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Status Perkawinan</label>
            <select name="status_perkawinan" required class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('status_perkawinan') border-red-500 @enderror">
                <option value="">Pilih Status Perkawinan</option>
                <option value="Belum Menikah" {{ old('status_perkawinan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                <option value="Menikah" {{ old('status_perkawinan') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                <option value="Cerai" {{ old('status_perkawinan') == 'Cerai' ? 'selected' : '' }}>Cerai</option>
            </select>
            @error('status_perkawinan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block font-medium mb-1">Status Tinggal</label>
            <select name="status_tinggal" required class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white @error('status_tinggal') border-red-500 @enderror">
                <option value="">Pilih Status Tinggal</option>
                <option value="Tetap" {{ old('status_tinggal') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="Pindah" {{ old('status_tinggal') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                <option value="Meninggal" {{ old('status_tinggal') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
            </select>
            @error('status_tinggal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Simpan Data
        </button>
    </form>
</div>
@endsection
