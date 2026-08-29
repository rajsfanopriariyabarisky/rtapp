extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Tambah Data Keluarga</h2>
            <a href="{{ route('warga.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Kembali ke Dashboard
            </a>
        </div>

        <!-- Informasi Sistem Persetujuan -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-start">
                <i class="fa fa-info-circle text-blue-500 mt-1 mr-3"></i>
                <div>
                    <h3 class="text-blue-800 font-medium mb-1">Sistem Persetujuan RT</h3>
                    <p class="text-blue-700 text-sm">
                        Data anggota keluarga yang Anda tambahkan akan dikirim untuk persetujuan RT terlebih dahulu. 
                        RT akan memverifikasi data sebelum disetujui dan ditambahkan ke database warga.
                    </p>
                </div>
            </div>
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

        <form method="POST" action="{{ route('warga.family.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        NIK <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nik" 
                           name="nik" 
                           value="{{ old('nik') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Masukkan NIK 16 digit"
                           maxlength="16"
                           required>
                    @error('nik')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama_lengkap" 
                           name="nama_lengkap" 
                           value="{{ old('nama_lengkap') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Masukkan nama lengkap"
                           required>
                    @error('nama_lengkap')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tempat Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="tempat_lahir" 
                           name="tempat_lahir" 
                           value="{{ old('tempat_lahir') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Masukkan tempat lahir"
                           required>
                    @error('tempat_lahir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
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

                <!-- Jenis Kelamin -->
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <select id="jenis_kelamin" 
                            name="jenis_kelamin"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Agama -->
                <div>
                    <label for="agama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Agama
                    </label>
                    <select id="agama" 
                            name="agama"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        <option value="Lainnya" {{ old('agama') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('agama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pekerjaan -->
                <div>
                    <label for="pekerjaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pekerjaan
                    </label>
                    <input type="text" 
                           id="pekerjaan" 
                           name="pekerjaan" 
                           value="{{ old('pekerjaan') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Masukkan pekerjaan">
                    @error('pekerjaan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Perkawinan -->
                <div>
                    <label for="status_perkawinan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Status Perkawinan <span class="text-red-500">*</span>
                    </label>
                    <select id="status_perkawinan" 
                            name="status_perkawinan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            required>
                        <option value="">Pilih Status Perkawinan</option>
                        <option value="Belum Menikah" {{ old('status_perkawinan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="Menikah" {{ old('status_perkawinan') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="Cerai" {{ old('status_perkawinan') == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                    </select>
                    @error('status_perkawinan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Tinggal -->
                <div>
                    <label for="status_tinggal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Status Tinggal <span class="text-red-500">*</span>
                    </label>
                    <select id="status_tinggal" 
                            name="status_tinggal"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            required>
                        <option value="Tetap" {{ old('status_tinggal') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                        <option value="Pindah" {{ old('status_tinggal') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                        <option value="Meninggal" {{ old('status_tinggal') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                    </select>
                    @error('status_tinggal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- RT -->
                <div>
                    <label for="rt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        RT <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="rt" 
                           name="rt" 
                           value="{{ old('rt') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Masukkan nomor RT"
                           required>
                    @error('rt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- RW -->
                <div>
                    <label for="rw" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        RW <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="rw" 
                           name="rw" 
                           value="{{ old('rw') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Masukkan nomor RW"
                           required>
                    @error('rw')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label for="telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="telepon" 
                           name="telepon" 
                           value="{{ old('telepon') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Masukkan nomor telepon"
                           required>
                    @error('telepon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Masukkan email">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Alamat Lengkap <span class="text-red-500">*</span>
                </label>
                <textarea id="alamat" 
                          name="alamat" 
                          rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                          placeholder="Masukkan alamat lengkap"
                          required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="hubungan_keluarga" class="block font-medium mb-1">Hubungan Keluarga <span class="text-red-500">*</span></label>
                <select name="hubungan_keluarga" id="hubungan_keluarga" required class="w-full rounded border-gray-300 p-2 dark:bg-gray-800 dark:text-white">
                    <option value="">Pilih Hubungan</option>
                    <option value="Kepala Keluarga">Kepala Keluarga</option>
                    <option value="Istri">Istri</option>
                    <option value="Anak">Anak</option>
                    <option value="Saudara">Saudara</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                @error('hubungan_keluarga')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('warga.dashboard') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Kirim untuk Persetujuan RT
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 