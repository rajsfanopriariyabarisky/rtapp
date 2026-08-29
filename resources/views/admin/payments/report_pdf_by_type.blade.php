<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran {{ $type }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .stats {
            margin-bottom: 20px;
        }
        .stats table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .stats th, .stats td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .stats th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .payment-table th, .payment-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }
        .payment-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .status-lunas {
            color: #28a745;
            font-weight: bold;
        }
        .status-proses {
            color: #ffc107;
            font-weight: bold;
        }
        .status-belum {
            color: #dc3545;
            font-weight: bold;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PEMBAYARAN {{ strtoupper($type) }}</h1>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <h3>Ringkasan Statistik</h3>
        <table>
            <tr>
                <th>Total Tagihan</th>
                <td>Rp {{ number_format($stats['total_amount']) }}</td>
            </tr>
            <tr>
                <th>Total Lunas</th>
                <td>Rp {{ number_format($stats['total_paid']) }}</td>
            </tr>
            <tr>
                <th>Total Pending</th>
                <td>Rp {{ number_format($stats['total_pending']) }}</td>
            </tr>
            <tr>
                <th>Jumlah Transaksi</th>
                <td>{{ $stats['count'] }} transaksi</td>
            </tr>
            <tr>
                <th>Jumlah Lunas</th>
                <td>{{ $stats['paid_count'] }} transaksi</td>
            </tr>
            <tr>
                <th>Jumlah Pending</th>
                <td>{{ $stats['pending_count'] }} transaksi</td>
            </tr>
        </table>
    </div>

    <div class="payment-details">
        <h3>Detail Pembayaran</h3>
        <table class="payment-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Warga</th>
                    <th>Email</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Jatuh Tempo</th>
                    <th>Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $index => $payment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payment->user->nama }}</td>
                    <td>{{ $payment->user->email }}</td>
                    <td>Rp {{ number_format($payment->amount) }}</td>
                    <td class="status-{{ $payment->status }}">
                        @if($payment->status == 'lunas')
                            LUNAS
                        @elseif($payment->status == 'proses')
                            PROSES
                        @else
                            BELUM BAYAR
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3"><strong>TOTAL</strong></td>
                    <td><strong>Rp {{ number_format($payments->sum('amount')) }}</strong></td>
                    <td colspan="3"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem RT/RW</p>
        <p>© {{ date('Y') }} Sistem RT/RW</p>
    </div>
</body>
</html> 