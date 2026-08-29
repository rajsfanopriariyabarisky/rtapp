@extends('layouts.app')

@section('title', 'Detail Pengajuan Anggota Keluarga')

@section('content')
<div x-data="{ approveModal: false, rejectModal: false }" class="p-4 md:p-8 2xl:p-12">
    <div class="mx-auto max-w-5xl">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-black dark:text-white">
                Detail Pengajuan Anggota Keluarga
            </h2>
            <a href="{{ route('family-approvals.index') }}" 
               class="inline-flex items-center justify-center rounded-lg bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 py-2 px-8 text-center font-semibold text-white shadow-sm hover:shadow-md transition duration-200 lg:px-8 xl:px-10">
                Kembali
            </a>
        </div>

        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-6 pt-8 pb-4 shadow-lg sm:px-10 xl:pb-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Informasi Pengaju -->
                <div>
                    <h3 class="text-lg font-semibold mb-5 text-gray-900 dark:text-white">Informasi Pengaju</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Nama</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->user->nama }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Email</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Status Pengajuan</label>
                            @if($familyApproval->status === 'Menunggu')
                                <span class="inline-flex rounded-full bg-yellow-100 dark:bg-yellow-900/30 py-1 px-4 text-sm font-semibold text-yellow-800 dark:text-yellow-200">Menunggu</span>
                            @elseif($familyApproval->status === 'Disetujui')
                                <span class="inline-flex rounded-full bg-green-100 dark:bg-green-900/30 py-1 px-4 text-sm font-semibold text-green-800 dark:text-green-200">Disetujui</span>
                            @else
                                <span class="inline-flex rounded-full bg-red-100 dark:bg-red-900/30 py-1 px-4 text-sm font-semibold text-red-800 dark:text-red-200">Ditolak</span>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Tanggal Pengajuan</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($familyApproval->approved_at)
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Tanggal Persetujuan</label>
                                <p class="text-gray-900 dark:text-white">{{ $familyApproval->approved_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Disetujui Oleh</label>
                                <p class="text-gray-900 dark:text-white">{{ $familyApproval->approvedBy->nama ?? '-' }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informasi Anggota Keluarga -->
                <div>
                    <h3 class="text-lg font-semibold mb-5 text-gray-900 dark:text-white">Data Anggota Keluarga</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">NIK</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->nik }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Nama Lengkap</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->nama_lengkap }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Tempat, Tanggal Lahir</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->tempat_lahir }}, {{ $familyApproval->tanggal_lahir->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Jenis Kelamin</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Agama</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->agama ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Pekerjaan</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->pekerjaan ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Status Perkawinan</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->status_perkawinan }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Status Tinggal</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->status_tinggal }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Hubungan Keluarga</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->hubungan_keluarga }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Kontak dan Alamat -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-5 text-gray-900 dark:text-white">Informasi Kontak & Alamat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Telepon</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->telepon }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Email</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">RT/RW</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->rt }}/{{ $familyApproval->rw }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Alamat</label>
                            <p class="text-gray-900 dark:text-white">{{ $familyApproval->alamat }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($familyApproval->alasan_penolakan)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-5 text-black dark:text-white">Alasan Penolakan</h3>
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <p class="text-red-800 dark:text-red-200">{{ $familyApproval->alasan_penolakan }}</p>
                    </div>
                </div>
            @endif

            <!-- Tombol Aksi -->
            @if($familyApproval->status === 'Menunggu')
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <button onclick="openApproveModal()" type="button"
                            class="inline-flex items-center justify-center rounded-lg bg-green-600 dark:bg-green-500 py-2 px-8 text-center font-semibold text-white shadow hover:bg-green-700 dark:hover:bg-green-600 transition">
                        Setujui Pengajuan
                    </button>
                    <button onclick="openRejectModal()" type="button"
                            class="inline-flex items-center justify-center rounded-lg bg-red-600 dark:bg-red-500 py-2 px-8 text-center font-semibold text-white shadow hover:bg-red-700 dark:hover:bg-red-600 transition">
                        Tolak Pengajuan
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Persetujuan -->
    <div id="approveModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-8 w-full max-w-md mx-4 shadow-lg">
            <h3 class="text-lg font-semibold mb-5 text-gray-900 dark:text-white">Setujui Pengajuan</h3>
            <form method="POST" action="{{ route('family-approvals.approve', $familyApproval->id) }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Alasan (Opsional)</label>
                    <textarea name="alasan" rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeApproveModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 dark:bg-green-500 text-white rounded-lg font-semibold hover:bg-green-700 dark:hover:bg-green-600 transition">Setujui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Penolakan -->
    <div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-8 w-full max-w-md mx-4 shadow-lg">
            <h3 class="text-lg font-semibold mb-5 text-gray-900 dark:text-white">Tolak Pengajuan</h3>
            <form method="POST" action="{{ route('family-approvals.reject', $familyApproval->id) }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Alasan Penolakan <span class="text-red-600 dark:text-red-400">*</span></label>
                    <textarea name="alasan" rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400" required></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 dark:bg-red-500 text-white rounded-lg font-semibold hover:bg-red-700 dark:hover:bg-red-600 transition">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openApproveModal() {
    document.getElementById('approveModal').classList.remove('hidden');
    document.getElementById('approveModal').classList.add('flex');
}

function openRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectModal').classList.add('flex');
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
    document.getElementById('approveModal').classList.remove('flex');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectModal').classList.remove('flex');
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const approveModal = document.getElementById('approveModal');
    const rejectModal = document.getElementById('rejectModal');
    
    if (approveModal) {
        approveModal.addEventListener('click', function(e) {
            if (e.target === approveModal) {
                closeApproveModal();
            }
        });
    }
    
    if (rejectModal) {
        rejectModal.addEventListener('click', function(e) {
            if (e.target === rejectModal) {
                closeRejectModal();
            }
        });
    }
});
</script>
@endsection 