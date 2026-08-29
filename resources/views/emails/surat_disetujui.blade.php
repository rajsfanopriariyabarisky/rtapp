<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Disetujui</title>
</head>
<body>
    <p>Yth. {{ $letter->resident->nama }},</p>

    <p>Selamat! Surat pengajuan <strong>{{ $letter->jenis_surat }}</strong> Anda telah <strong>disetujui</strong>.</p>

    <p>Keperluan: {{ $letter->keperluan }}</p>
    <p>Tanggal Pengajuan: {{ $letter->tanggal_pengajuan->format('d M Y') }}</p>
    <p>Tanggal Disetujui: {{ $letter->tanggal_disetujui->format('d M Y') }}</p>

    <p>Anda dapat mengunduh surat Anda melalui sistem kami.</p>

    <p>Terima kasih telah menggunakan layanan RT/RW digital.</p>

    <br>
    <p>Salam,</p>
    <p>Pengurus RT/RW</p>
</body>
</html>
