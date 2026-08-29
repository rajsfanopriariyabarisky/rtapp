<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #eee; }
        h2, h3 { margin: 10px 0 5px; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Pembayaran per Jenis Tagihan</h2>
    <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>

    @foreach($grouped as $title => $payments)
        <h3>Jenis Tagihan: {{ $title }}</h3>

        <table>
            <thead>
                <tr>
                    <th>Nama Warga</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Jatuh Tempo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->user->name ?? 'Tidak diketahui' }}</td>
                        <td>Rp{{ number_format($payment->amount) }}</td>
                        <td>{{ ucfirst($payment->status) }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->due_date)->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

</body>
</html>
