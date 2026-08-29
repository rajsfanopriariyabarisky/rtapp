@extends('layouts.app')

@section('title', 'Persetujuan Anggota Keluarga')

@section('content')
<div class="p-4 md:p-8 2xl:p-12">
    <div class="mx-auto max-w-7xl">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Persetujuan Anggota Keluarga</h2>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded border border-green-400 bg-green-50 dark:bg-green-900/20 px-4 py-3 text-green-700 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded border border-red-400 bg-red-50 dark:bg-red-900/20 px-4 py-3 text-red-700 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter Section -->
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('family-approvals.index') }}" id="filter-form" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">🔍 Pencarian</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nama, NIK, atau pengaju..."
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📌 Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                        @foreach($statusList as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Hubungan Keluarga -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">👨‍👩‍👧‍👦 Hubungan</label>
                    <select name="hubungan" class="w-full rounded-lg border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20">
                        <option value="all" {{ request('hubungan') == 'all' ? 'selected' : '' }}>Semua</option>
                        @foreach($hubunganList as $hubungan)
                            <option value="{{ $hubungan }}" {{ request('hubungan') == $hubungan ? 'selected' : '' }}>{{ $hubungan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📅 Tanggal Mulai</label>
                    <div class="relative">
                        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" 
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 px-3 py-2 pr-10 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20">
                        <button type="button" onclick="this.previousElementSibling.showPicker()" 
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 cursor-pointer">
                            📅
                        </button>
                    </div>
                </div>

                <!-- Tanggal Akhir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📅 Tanggal Akhir</label>
                    <div class="relative">
                        <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" 
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 px-3 py-2 pr-10 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20">
                        <button type="button" onclick="this.previousElementSibling.showPicker()" 
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 cursor-pointer">
                            📅
                        </button>
                    </div>
                </div>
            </form>

            <!-- Filter Actions -->
            <div class="flex justify-between items-center mt-4">
                <div class="flex gap-2">
                    <button type="submit" form="filter-form" 
                            class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 shadow-sm">
                        🔍 Terapkan Filter
                    </button>
                    <a href="{{ route('family-approvals.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 shadow-sm">
                        🔄 Reset
                    </a>
                </div>
                
                <!-- Sorting -->
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Urutkan:</span>
                    <a href="{{ route('family-approvals.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => $direction === 'asc' ? 'desc' : 'asc'])) }}" 
                       class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition">
                        Tanggal {!! $sort === 'created_at' ? ($direction === 'asc' ? '↑' : '↓') : '' !!}
                    </a>
                    <a href="{{ route('family-approvals.index', array_merge(request()->all(), ['sort' => 'nama_lengkap', 'direction' => $direction === 'asc' ? 'desc' : 'asc'])) }}" 
                       class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition">
                        Nama {!! $sort === 'nama_lengkap' ? ($direction === 'asc' ? '↑' : '↓') : '' !!}
                    </a>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 pt-4 pb-2.5 shadow-sm dark:shadow-gray-900/50 sm:px-8 xl:pb-1">
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-800 text-left">
                            <th class="py-3 px-4 font-semibold text-gray-700 dark:text-gray-200">Pengaju</th>
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
                            <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-gray-800 dark:text-white">{{ $approval->user->nama }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $approval->user->email }}</div>
                                </td>
                                <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $approval->nik }}</td>
                                <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $approval->nama_lengkap }}</td>
                                <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $approval->hubungan_keluarga }}</td>
                                <td class="py-3 px-4">
                                    @if($approval->status === 'Menunggu')
                                        <span class="inline-flex rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200 px-3 py-1 text-xs font-semibold">Menunggu</span>
                                    @elseif($approval->status === 'Disetujui')
                                        <span class="inline-flex rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 px-3 py-1 text-xs font-semibold">Disetujui</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 px-3 py-1 text-xs font-semibold">Ditolak</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $approval->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('family-approvals.show', $approval->id) }}"
                                           class="inline-flex items-center gap-1 rounded bg-blue-500 dark:bg-blue-600 px-3 py-1 text-xs font-semibold text-white hover:bg-blue-600 dark:hover:bg-blue-700 transition">
                                            <i class="fa fa-eye"></i> Detail
                                        </a>
                                        @if($approval->status === 'Menunggu')
                                            <button onclick="openApproveModal({{ $approval->id }})" type="button"
                                                class="inline-flex items-center gap-1 rounded bg-green-600 dark:bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700 dark:hover:bg-green-800 transition">
                                                <i class="fa fa-check"></i> Setujui
                                            </button>
                                            <button onclick="openRejectModal({{ $approval->id }})" type="button"
                                                class="inline-flex items-center gap-1 rounded bg-red-600 dark:bg-red-700 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 dark:hover:bg-red-800 transition">
                                                <i class="fa fa-times"></i> Tolak
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 px-4 text-center text-gray-500 dark:text-gray-400">Tidak ada pengajuan persetujuan</td>
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
</div>

<!-- Modal Persetujuan -->
<div id="approveModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 dark:bg-black/70 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-8 w-full max-w-md mx-4 shadow-xl dark:shadow-gray-900/50">
        <h3 class="text-lg font-semibold mb-5 text-gray-800 dark:text-white">Setujui Pengajuan</h3>
        <form id="approveForm" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Alasan (Opsional)</label>
                <textarea name="alasan" rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400 focus:border-green-500 dark:focus:border-green-400"></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeApproveModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 dark:bg-green-700 text-white rounded-lg font-semibold hover:bg-green-700 dark:hover:bg-green-800 transition">Setujui</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Penolakan -->
<div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 dark:bg-black/70 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-8 w-full max-w-md mx-4 shadow-xl dark:shadow-gray-900/50">
        <h3 class="text-lg font-semibold mb-5 text-gray-800 dark:text-white">Tolak Pengajuan</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Alasan Penolakan <span class="text-red-600 dark:text-red-400">*</span></label>
                <textarea name="alasan" rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400" required></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 dark:bg-red-700 text-white rounded-lg font-semibold hover:bg-red-700 dark:hover:bg-red-800 transition">Tolak</button>
            </div>
        </form>
    </div>
</div>

<script>
function openApproveModal(approvalId) {
    const form = document.getElementById('approveForm');
    form.action = `/family-approvals/${approvalId}/approve`;
    document.getElementById('approveModal').classList.remove('hidden');
    document.getElementById('approveModal').classList.add('flex');
}

function openRejectModal(approvalId) {
    const form = document.getElementById('rejectForm');
    form.action = `/family-approvals/${approvalId}/reject`;
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