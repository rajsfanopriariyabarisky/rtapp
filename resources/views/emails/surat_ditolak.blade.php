<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Penolakan Surat</title>
</head>
<body>
    <p>Yth. {{ $letter->resident->nama }},</p>

    <p>Dengan ini kami informasikan bahwa pengajuan surat <strong>{{ $letter->jenis_surat }}</strong> Anda telah <strong>ditolak</strong>.</p>

    <p>Keperluan: {{ $letter->keperluan }}</p>
    <p>Tanggal Pengajuan: {{ $letter->tanggal_pengajuan->format('d M Y') }}</p>

    <p>Anda dapat melihat surat penolakan yang telah dibuat pada sistem kami.</p>

    <p>Terima kasih atas perhatian Anda.</p>

    <br>
    <p>Salam,</p>
    <p>Pengurus RT/RW</p>
</body>
</html>
