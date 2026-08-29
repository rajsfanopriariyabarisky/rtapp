@extends('layouts.app')

@section('title', 'Pengajuan Anggota Keluarga Saya')

@section('content')
<div class="p-4 md:p-8 2xl:p-12" x-data="{ open: false, alasan: '' }">
    <div class="mx-auto max-w-6xl">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Pengajuan Anggota Keluarga Saya</h2>
            <a href="{{ route('warga.family.create') }}"
               class="inline-flex items-center justify-center rounded-lg bg-blue-600 py-2 px-6 text-center font-semibold text-white shadow hover:bg-blue-700 transition">
                <i class="fa fa-plus mr-2"></i> Tambah Anggota Keluarga
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded border border-green-400 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded border border-red-400 bg-red-50 px-4 py-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="rounded-lg border border-gray-200 bg-white px-4 pt-4 pb-2.5 shadow dark:border-gray-700 dark:bg-gray-900 sm:px-8 xl:pb-1">
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left dark:bg-gray-800">
                            <th class="py-3 px-4 font-semibold text-gray-700 dark:text-gray-200">NIK</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 dark:text-gray-200">Nama</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 dark:text-gray-200">Hubungan</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 dark:text-gray-200">Status</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 dark:text-gray-200">Tanggal</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 dark:text-gray-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($approvals as $approval)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="py-3 px-4">{{ $approval->nik }}</td>
                                <td class="py-3 px-4">{{ $approval->nama_lengkap }}</td>
                                <td class="py-3 px-4">{{ $approval->hubungan_keluarga }}</td>
                                <td class="py-3 px-4">
                                    @if($approval->status === 'Menunggu')
                                        <span class="inline-flex rounded-full bg-yellow-100 text-yellow-800 px-3 py-1 text-xs font-semibold">Menunggu</span>
                                    @elseif($approval->status === 'Disetujui')
                                        <span class="inline-flex rounded-full bg-green-100 text-green-800 px-3 py-1 text-xs font-semibold">Disetujui</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-red-100 text-red-800 px-3 py-1 text-xs font-semibold">Ditolak</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">{{ $approval->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-2">
                                        @if($approval->status === 'Menunggu')
                                            <form action="{{ route('family-approvals.destroy', $approval->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 rounded bg-red-500 px-3 py-1 text-xs font-semibold text-white hover:bg-red-600 transition">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                        @if($approval->status === 'Ditolak' && $approval->alasan_penolakan)
                                            <button @click="open = true; alasan = '{{ $approval->alasan_penolakan }}'"
                                                class="inline-flex items-center gap-1 rounded bg-gray-200 px-3 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition">
                                                <i class="fa fa-info-circle"></i> Lihat Alasan
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 px-4 text-center text-gray-500 dark:text-gray-300">Tidak ada pengajuan persetujuan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $approvals->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Alasan Penolakan -->
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md mx-4 shadow-lg">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Alasan Penolakan</h3>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alasan</label>
                <textarea x-model="alasan" readonly rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white"></textarea>
            </div>
            <div class="flex justify-end">
                <button @click="open = false" type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection 