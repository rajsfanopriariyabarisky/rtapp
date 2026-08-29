@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-2 fw-bold text-center">📋 Laporan Pembayaran per Jenis Tagihan</h2>
    <p class="text-center text-muted">🗓 Tanggal Cetak: {{ now()->format('d-m-Y') }}</p>

    <div class="text-end mb-3">
        <a href="{{ route('admin.payments.exportPdf') }}" class="btn btn-outline-danger" target="_blank">
            <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Jenis Tagihan</th>
                            <th>Nama Warga</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Jatuh Tempo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grouped as $title => $rows)
                            @foreach($rows as $payment)
                                <tr>
                                    <td>{{ $title }}</td>
                                    <td>{{ $payment->user->name }}</td>
                                    <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if($payment->status == 'belum')
                                            <span class="badge bg-danger">Belum</span>
                                        @elseif($payment->status == 'proses')
                                            <span class="badge bg-warning text-dark">Proses</span>
                                        @else
                                            <span class="badge bg-success">Lunas</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($payment->due_date)->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <em>Tidak ada data pembayaran.</em>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection