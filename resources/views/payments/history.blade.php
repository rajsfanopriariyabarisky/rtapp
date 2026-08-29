@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Pembayaran Saya</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Jatuh Tempo</th>
                <th>Bukti</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->title }}</td>
                    <td>Rp{{ number_format($payment->amount) }}</td>
                    <td>
                        @if($payment->status == 'lunas')
                            <span class="badge bg-success">Lunas</span>
                        @elseif($payment->status == 'proses')
                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                        @else
                            <span class="badge bg-danger">Belum</span>
                        @endif
                    </td>
                    <td>{{ $payment->due_date }}</td>
                    <td>
                        @if($payment->proof)
                            <a href="{{ asset('storage/' . $payment->proof) }}" target="_blank">Lihat Bukti</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
