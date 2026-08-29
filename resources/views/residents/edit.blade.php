@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-900 shadow rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Edit Data Diri</h2>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <h4 class="font-medium mb-2">Terjadi kesalahan pada form:</h4>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('residents.update', $resident->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700 dark:text-gray-200">NIK</label>
                <input type="text" name="nik" id="nik" value="{{ old('nik', $resident->nik) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('nik') border-red-500 @enderror">
                @error('nik') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $resident->nama_lengkap) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('nama_lengkap') border-red-500 @enderror">
                @error('nama_lengkap') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $resident->tempat_lahir) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('tempat_lahir') border-red-500 @enderror">
                @error('tempat_lahir') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">Tanggal Lahir</label>
                <div class="relative">
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $resident->tanggal_lahir) }}" required 
                           class="w-full px-3 py-2 pr-10 border rounded dark:bg-gray-800 dark:text-white @error('tanggal_lahir') border-red-500 @enderror">
                    <button type="button" onclick="this.previousElementSibling.showPicker()" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 cursor-pointer">
                        📅
                    </button>
                </div>
                @error('tanggal_lahir') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('jenis_kelamin') border-red-500 @enderror">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('jenis_kelamin', $resident->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $resident->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="agama" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Agama</label>
                <select name="agama" id="agama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('agama') border-red-500 @enderror">
                    <option value="">Pilih Agama</option>
                    <option value="Islam" {{ old('agama', $resident->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ old('agama', $resident->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ old('agama', $resident->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ old('agama', $resident->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Buddha" {{ old('agama', $resident->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Konghucu" {{ old('agama', $resident->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    <option value="Lainnya" {{ old('agama', $resident->agama) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('agama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="pekerjaan" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pekerjaan</label>
                <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan', $resident->pekerjaan) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('pekerjaan') border-red-500 @enderror">
                @error('pekerjaan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="status_perkawinan" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status Perkawinan</label>
                <select name="status_perkawinan" id="status_perkawinan" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('status_perkawinan') border-red-500 @enderror">
                    <option value="">Pilih Status Perkawinan</option>
                    <option value="Belum Menikah" {{ old('status_perkawinan', $resident->status_perkawinan) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                    <option value="Menikah" {{ old('status_perkawinan', $resident->status_perkawinan) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                    <option value="Cerai" {{ old('status_perkawinan', $resident->status_perkawinan) == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                </select>
                @error('status_perkawinan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="status_tinggal" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status Tinggal</label>
                <select name="status_tinggal" id="status_tinggal" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('status_tinggal') border-red-500 @enderror">
                    <option value="">Pilih Status Tinggal</option>
                    <option value="Tetap" {{ old('status_tinggal', $resident->status_tinggal) == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="Pindah" {{ old('status_tinggal', $resident->status_tinggal) == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                    <option value="Meninggal" {{ old('status_tinggal', $resident->status_tinggal) == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                </select>
                @error('status_tinggal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Alamat</label>
                <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $resident->alamat) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('alamat') border-red-500 @enderror">
                @error('alamat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="rt" class="block text-sm font-medium text-gray-700 dark:text-gray-200">RT</label>
                <input type="text" name="rt" id="rt" value="{{ old('rt', $resident->rt) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('rt') border-red-500 @enderror">
                @error('rt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="rw" class="block text-sm font-medium text-gray-700 dark:text-gray-200">RW</label>
                <input type="text" name="rw" id="rw" value="{{ old('rw', $resident->rw) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('rw') border-red-500 @enderror">
                @error('rw') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Telepon</label>
                <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $resident->telepon) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('telepon') border-red-500 @enderror">
                @error('telepon') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $resident->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('email') border-red-500 @enderror">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
