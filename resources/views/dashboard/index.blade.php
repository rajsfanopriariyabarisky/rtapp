@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-2xl font-semibold mb-6">Dashboard RT/RW</h1>

    <h2>Dashboard {{ ucfirst(Auth::user()->role) }}</h2>

    @if (Auth::user()->role == 'admin')
        <p>Halo Admin, berikut rekap akun pending, laporan warga, dan statistik warga.</p>

    @elseif (Auth::user()->role == 'rt')
        <p>Halo RT, Anda bisa melihat surat warga, pengaduan, dan laporan kas RT.</p>

    @elseif (Auth::user()->role == 'rw')
        <p>Selamat datang RW, Anda dapat memantau kinerja RT dan data laporan warga.</p>

    @elseif (Auth::user()->role == 'warga')
        <p>Halo Warga, silakan ajukan surat atau buat pengaduan melalui menu samping.</p>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="card bg-white shadow p-4 rounded-lg">
            <h2 class="text-lg font-bold mb-2">Akun Menunggu Persetujuan</h2>
            <p class="text-3xl font-semibold text-red-500">{{ $akunBaruCount }}</p>
            <a href="{{ route('users.pending') }}" class="text-blue-500 hover:underline mt-2 inline-block">Lihat Detail</a>
        </div>
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-sm text-gray-600">Jumlah Warga</h2>
            <p class="text-2xl font-bold text-blue-600">{{ $totalResidents }}</p>
        </div>

        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-sm text-gray-600">Surat Menunggu</h2>
            <p class="text-2xl font-bold text-yellow-500">{{ $pendingLetters }}</p>
        </div>

        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-sm text-gray-600">Pengaduan Aktif</h2>
            <p class="text-2xl font-bold text-red-500">{{ $activeComplaints }}</p>
        </div>

        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-sm text-gray-600">Saldo Kas</h2>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($kasSaldo, 0, ',', '.') }}</p>
        </div>
    </div>
</div>
@endsection
