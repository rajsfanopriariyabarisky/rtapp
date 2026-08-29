<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Baru - RT/RW</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #3b82f6;
            margin: 0;
            font-size: 24px;
        }
        .greeting {
            font-size: 18px;
            color: #374151;
            margin-bottom: 20px;
        }
        .announcement-box {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .announcement-title {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .announcement-content {
            color: #4b5563;
            line-height: 1.8;
            margin-bottom: 15px;
        }
        .announcement-meta {
            font-size: 14px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
        .cta-button {
            display: inline-block;
            background-color: #3b82f6;
            color: #ffffff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .cta-button:hover {
            background-color: #2563eb;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #3b82f6;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🏘️ RT/RW</div>
            <h1>Pengumuman Baru</h1>
        </div>

        <div class="greeting">
            Halo <strong>{{ $notifiable->nama }}</strong>! 👋
        </div>

        <p>Ada pengumuman baru dari RT/RW yang perlu Anda ketahui:</p>

        <div class="announcement-box">
            <div class="announcement-title">
                📢 {{ $announcement->title }}
            </div>
            <div class="announcement-content">
                {!! nl2br(e($announcement->content)) !!}
            </div>
            <div class="announcement-meta">
                📅 <strong>Tanggal:</strong> {{ $announcement->created_at ? $announcement->created_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}
            </div>
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/pengumuman') }}" class="cta-button">
                📋 Lihat Semua Pengumuman
            </a>
        </div>

        <div class="footer">
            <p><strong>Terima kasih telah menggunakan layanan RT/RW kami.</strong></p>
            <p>Salam,<br>Tim RT/RW</p>
            <p style="font-size: 12px; color: #9ca3af;">
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html> 