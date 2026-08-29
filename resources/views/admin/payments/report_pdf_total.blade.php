<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran Total</title>
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
        .overall-stats {
            margin-bottom: 20px;
        }
        .overall-stats table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .overall-stats th, .overall-stats td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .overall-stats th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .type-summary {
            margin-bottom: 20px;
        }
        .type-summary table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .type-summary th, .type-summary td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .type-summary th {
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
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PEMBAYARAN TOTAL KESELURUHAN</h1>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="overall-stats">
        <h3>Statistik Keseluruhan</h3>
        <table>
            <tr>
                <th>Total Tagihan</th>
                <td>Rp {{ number_format($overallStats['total_amount']) }}</td>
            </tr>
            <tr>
                <th>Total Lunas</th>
                <td>Rp {{ number_format($overallStats['total_paid']) }}</td>
            </tr>
            <tr>
                <th>Total Pending</th>
                <td>Rp {{ number_format($overallStats['total_pending']) }}</td>
            </tr>
            <tr>
                <th>Jumlah Transaksi</th>
                <td>{{ $overallStats['count'] }} transaksi</td>
            </tr>
            <tr>
                <th>Jumlah Lunas</th>
                <td>{{ $overallStats['paid_count'] }} transaksi</td>
            </tr>
            <tr>
                <th>Jumlah Pending</th>
                <td>{{ $overallStats['pending_count'] }} transaksi</td>
            </tr>
        </table>
    </div>

    <div class="type-summary">
        <h3>Ringkasan per Jenis Tagihan</h3>
        <table>
            <thead>
                <tr>
                    <th>Jenis Tagihan</th>
                    <th>Total Tagihan</th>
                    <th>Total Lunas</th>
                    <th>Total Pending</th>
                    <th>Jumlah Transaksi</th>
                    <th>Jumlah Lunas</th>
                    <th>Jumlah Pending</th>
                </tr>
            </thead>
            <tbody>
                @foreach($totalsByType as $type => $stats)
                <tr>
                    <td>{{ $type }}</td>
                    <td>Rp {{ number_format($stats['total_amount']) }}</td>
                    <td>Rp {{ number_format($stats['total_paid']) }}</td>
                    <td>Rp {{ number_format($stats['total_pending']) }}</td>
                    <td>{{ $stats['count'] }}</td>
                    <td>{{ $stats['paid_count'] }}</td>
                    <td>{{ $stats['pending_count'] }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>TOTAL</strong></td>
                    <td><strong>Rp {{ number_format($overallStats['total_amount']) }}</strong></td>
                    <td><strong>Rp {{ number_format($overallStats['total_paid']) }}</strong></td>
                    <td><strong>Rp {{ number_format($overallStats['total_pending']) }}</strong></td>
                    <td><strong>{{ $overallStats['count'] }}</strong></td>
                    <td><strong>{{ $overallStats['paid_count'] }}</strong></td>
                    <td><strong>{{ $overallStats['pending_count'] }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="payment-details">
        <h3>Detail Pembayaran per Jenis Tagihan</h3>
        
        @foreach($groupedByType as $type => $payments)
        <div class="section-title">{{ $type }}</div>
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
                    <td colspan="3"><strong>TOTAL {{ $type }}</strong></td>
                    <td><strong>Rp {{ number_format($payments->sum('amount')) }}</strong></td>
                    <td colspan="3"></td>
                </tr>
            </tbody>
        </table>
        @endforeach
    </div>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem RT/RW</p>
        <p>© {{ date('Y') }} Sistem RT/RW</p>
    </div>
</body>
</html> 