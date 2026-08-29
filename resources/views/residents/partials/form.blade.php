@php
    $isEdit = isset($resident);
@endphp

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Nama</label>
    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $isEdit ? $resident->nama_lengkap : '') }}"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('nama_lengkap') border-red-500 @enderror">
    @error('nama_lengkap') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">NIK</label>
    <input type="text" name="nik" value="{{ old('nik', $isEdit ? $resident->nik : '') }}"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('nik') border-red-500 @enderror">
    @error('nik') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Tempat Lahir</label>
    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $isEdit ? $resident->tempat_lahir : '') }}"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('tempat_lahir') border-red-500 @enderror">
    @error('tempat_lahir') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Tanggal Lahir</label>
    <div class="relative">
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $isEdit ? $resident->tanggal_lahir : '') }}"
            class="w-full px-3 py-2 pr-10 border rounded dark:bg-gray-800 dark:text-white @error('tanggal_lahir') border-red-500 @enderror">
        <button type="button" onclick="this.previousElementSibling.showPicker()" 
                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 cursor-pointer">
            📅
        </button>
    </div>
    @error('tanggal_lahir') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Alamat</label>
    <textarea name="alamat"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('alamat') border-red-500 @enderror">{{ old('alamat', $isEdit ? $resident->alamat : '') }}</textarea>
    @error('alamat') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">RT</label>
    <input type="text" name="rt" value="{{ old('rt', $isEdit ? $resident->rt : '') }}"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('rt') border-red-500 @enderror">
    @error('rt') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">RW</label>
    <input type="text" name="rw" value="{{ old('rw', $isEdit ? $resident->rw : '') }}"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('rw') border-red-500 @enderror">
    @error('rw') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Jenis Kelamin</label>
    <select name="jenis_kelamin"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('jenis_kelamin') border-red-500 @enderror">
        <option value="">Pilih</option>
        <option value="L" {{ old('jenis_kelamin', $isEdit ? $resident->jenis_kelamin : '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
        <option value="P" {{ old('jenis_kelamin', $isEdit ? $resident->jenis_kelamin : '') == 'P' ? 'selected' : '' }}>Perempuan</option>
    </select>
    @error('jenis_kelamin') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Agama</label>
    <select name="agama"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('agama') border-red-500 @enderror">
        <option value="">Pilih Agama</option>
        <option value="Islam" {{ old('agama', $isEdit ? $resident->agama : '') == 'Islam' ? 'selected' : '' }}>Islam</option>
        <option value="Kristen" {{ old('agama', $isEdit ? $resident->agama : '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
        <option value="Katolik" {{ old('agama', $isEdit ? $resident->agama : '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
        <option value="Hindu" {{ old('agama', $isEdit ? $resident->agama : '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
        <option value="Buddha" {{ old('agama', $isEdit ? $resident->agama : '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
        <option value="Konghucu" {{ old('agama', $isEdit ? $resident->agama : '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
        <option value="Lainnya" {{ old('agama', $isEdit ? $resident->agama : '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
    </select>
    @error('agama') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Telepon</label>
    <input type="text" name="telepon" value="{{ old('telepon', $isEdit ? $resident->telepon : '') }}"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('telepon') border-red-500 @enderror">
    @error('telepon') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Email</label>
    <input type="email" name="email" value="{{ old('email', $isEdit ? $resident->email : '') }}"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('email') border-red-500 @enderror">
    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Pekerjaan</label>
    <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $isEdit ? $resident->pekerjaan : '') }}"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('pekerjaan') border-red-500 @enderror">
    @error('pekerjaan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Status Perkawinan</label>
    <select name="status_perkawinan"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('status_perkawinan') border-red-500 @enderror">
        <option value="">Pilih Status</option>
        <option value="Belum Menikah" {{ old('status_perkawinan', $isEdit ? $resident->status_perkawinan : '') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
        <option value="Menikah" {{ old('status_perkawinan', $isEdit ? $resident->status_perkawinan : '') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
        <option value="Cerai" {{ old('status_perkawinan', $isEdit ? $resident->status_perkawinan : '') == 'Cerai' ? 'selected' : '' }}>Cerai</option>
    </select>
    @error('status_perkawinan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Status Tinggal</label>
    <select name="status_tinggal"
        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white @error('status_tinggal') border-red-500 @enderror">
        <option value="">Pilih Status</option>
        <option value="Tetap" {{ old('status_tinggal', $isEdit ? $resident->status_tinggal : '') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
        <option value="Pindah" {{ old('status_tinggal', $isEdit ? $resident->status_tinggal : '') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
        <option value="Meninggal" {{ old('status_tinggal', $isEdit ? $resident->status_tinggal : '') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
    </select>
    @error('status_tinggal') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>
