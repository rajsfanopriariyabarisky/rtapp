<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        .center { text-align: center; }
        .mt-5 { margin-top: 2rem; }
    </style>
</head>
<body>
    <h2 class="center">SURAT PENGANTAR</h2>
    <p class="center">No: {{ '00' . $letter->id }}/SP-RT/{{ date('Y') }}</p>

    <div class="mt-5">
        <p>Yang bertanda tangan di bawah ini menyatakan bahwa:</p>

        <table>
            <tr><td>Nama</td><td>: {{ $letter->resident?->nama_lengkap ?? '-' }}</td></tr>
            <tr><td>NIK</td><td>: {{ $letter->resident?->nik ?? '-' }}</td></tr>
            <tr><td>Alamat</td><td>: {{ $letter->resident?->alamat ?? '-' }}</td></tr>
            <tr><td>Keperluan</td><td>: {{ $letter->keperluan }}</td></tr>
            <tr><td>Tanggal Permohonan</td><td>: {{ \Carbon\Carbon::parse($letter->tanggal_pengajuan)->format('d-m-Y') }}</td></tr>
        </table>

        <p>Adalah benar warga kami dan surat ini dibuat untuk keperluan tersebut di atas.</p>

        <p class="mt-5">Demikian surat ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>

        <div class="mt-5" style="text-align: right;">
            <p>{{ now()->translatedFormat('d F Y') }}</p>
            <p>Ketua RT</p>
            <br><br>
            <p><strong>({{ $letter->signedBy->nama ?? '................................' }})</strong></p>
        </div>
    </div>
</body>
</html>
