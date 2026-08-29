<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Penolakan</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .content { line-height: 1.6; }
    </style>
</head>
<body>
    <div class="header">
        <h3>RT/RW Setempat</h3>
        <h4>SURAT PENOLAKAN PENGAJUAN</h4>
        <hr>
    </div>
    <div class="content">
        <p>Dengan ini kami memberitahukan bahwa pengajuan surat <strong>{{ $letter->jenis_surat }}</strong> oleh:</p>
        <ul>
            <li>Nama: {{ $letter->resident->nama }}</li>
            <li>Alamat: {{ $letter->resident->alamat }}</li>
            <li>Keperluan: {{ $letter->keperluan }}</li>
        </ul>
        <p><strong>Ditolak</strong> karena alasan administratif atau tidak sesuai dengan ketentuan.</p>
        <p>Demikian informasi ini disampaikan. Terima kasih atas pengertiannya.</p>

        <br><br>
        <div style="text-align: right;">
            <p>{{ now()->format('d M Y') }}</p>
            <p>TTD RT/RW</p>
            <br><br>
            <p>( {{ $letter->signedBy->name ?? 'Belum Ditandatangani' }} )</p>
        </div>
    </div>
</body>
</html>
