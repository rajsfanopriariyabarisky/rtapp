@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Data Keluarga Saya</h2>
            <div class="flex space-x-3">
                <a href="{{ route('warga.family.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Keluarga</span>
                </a>
                <a href="{{ route('warga.dashboard') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Kembali ke Dashboard
                </a>
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

        <!-- Data Kepala Keluarga -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Data Kepala Keluarga</h3>
            @if(auth()->user()->resident)
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">NIK</p>
                            <p class="font-semibold text-gray-800 dark:text-white">{{ auth()->user()->resident->nik }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Nama Lengkap</p>
                            <p class="font-semibold text-gray-800 dark:text-white">{{ auth()->user()->resident->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Tempat, Tanggal Lahir</p>
                            <p class="font-semibold text-gray-800 dark:text-white">
                                {{ auth()->user()->resident->tempat_lahir }}, {{ \Carbon\Carbon::parse(auth()->user()->resident->tanggal_lahir)->format('d/m/Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Jenis Kelamin</p>
                            <p class="font-semibold text-gray-800 dark:text-white">
                                {{ auth()->user()->resident->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pekerjaan</p>
                            <p class="font-semibold text-gray-800 dark:text-white">{{ auth()->user()->resident->pekerjaan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Status Perkawinan</p>
                            <p class="font-semibold text-gray-800 dark:text-white">{{ auth()->user()->resident->status_perkawinan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">RT/RW</p>
                            <p class="font-semibold text-gray-800 dark:text-white">{{ auth()->user()->resident->rt }}/{{ auth()->user()->resident->rw }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Telepon</p>
                            <p class="font-semibold text-gray-800 dark:text-white">{{ auth()->user()->resident->telepon }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Email</p>
                            <p class="font-semibold text-gray-800 dark:text-white">{{ auth()->user()->resident->email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Alamat</p>
                        <p class="font-semibold text-gray-800 dark:text-white">{{ auth()->user()->resident->alamat }}</p>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <p class="text-yellow-800 dark:text-yellow-200">
                        Anda belum melengkapi data diri. 
                        <a href="{{ route('residents.create') }}" class="underline font-semibold">Lengkapi data diri terlebih dahulu</a>
                    </p>
                </div>
            @endif
        </div>

        <!-- Daftar Anggota Keluarga -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Anggota Keluarga</h3>
            
            @if($familyMembers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50 dark:bg-gray-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    NIK
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nama Lengkap
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tempat, Tanggal Lahir
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Jenis Kelamin
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Pekerjaan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Hubungan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach($familyMembers as $member)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $member->nik }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $member->nama_lengkap }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $member->tempat_lahir }}, {{ \Carbon\Carbon::parse($member->tanggal_lahir)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $member->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $member->pekerjaan ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $member->status_tinggal == 'Tetap' ? 'bg-green-100 text-green-800' : 
                                               ($member->status_tinggal == 'Pindah' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $member->status_tinggal }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $member->hubungan_keluarga }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('warga.family.edit', $member->id) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                Edit
                                            </a>
                                            <form action="{{ route('warga.family.destroy', $member->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $familyMembers->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada anggota keluarga</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Mulai dengan menambahkan anggota keluarga baru.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('warga.family.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Tambah Anggota Keluarga
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 