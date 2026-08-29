@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold text-center mb-4">📊 Laporan Transparansi Dana Kas RT</h2>

    {{-- Info Total Kas --}}
    <div class="alert alert-info shadow-sm text-center fs-5">
        💰 Total Kas Masuk: <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong>
    </div>

    {{-- Tabel Pembayaran --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th scope="col">No</th>
                        <th scope="col">Nama Warga</th>
                        <th scope="col">Jumlah Bayar</th>
                        <th scope="col">Tanggal Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $i => $p)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td>Rp{{ number_format($p->amount, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada pembayaran kas RT.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection