@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Transparansi Dana Kas RT</h2>

    <div class="row mb-3">
        <div class="col-md-4">
            <div class="alert alert-success">
                <strong>Total Pemasukan:</strong> Rp{{ number_format($totalMasuk, 0, ',', '.') }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-danger">
                <strong>Total Pengeluaran:</strong> Rp{{ number_format($totalKeluar, 0, ',', '.') }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-info">
                <strong>Sisa Saldo:</strong> Rp{{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-secondary">
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kasItems as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $item->title }}</td>
                    <td>
                        @if($item->jenis === 'masuk')
                            <span class="badge bg-success">Masuk</span>
                        @else
                            <span class="badge bg-danger">Keluar</span>
                        @endif
                    </td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td>Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data kas RT.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection