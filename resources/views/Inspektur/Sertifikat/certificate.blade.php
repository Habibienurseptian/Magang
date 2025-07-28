<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Kompetensi</title>

    {{-- Tambahkan Google Fonts untuk Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: #fff;
            color: #222;
            margin: 0;
            padding: 0;
        }
        .certificate-box {
            border: 8px solid #2575fc;
            border-radius: 24px;
            padding: 40px 32px;
            max-width: 700px;
            margin: 40px auto;
            box-shadow: 0 8px 32px rgba(37,117,252,0.12);
            text-align: center;
        }
        .title {
            font-size: 36px;
            font-weight: bold;
            color: #2575fc;
            margin-bottom: 16px;
        }
        .subtitle {
            font-size: 18px;
            color: #444;
            margin-bottom: 24px;
        }
        .name {
            font-size: 32px;
            font-weight: 600;
            color: #222;
            margin-bottom: 16px;
        }
        .kompetensi {
            font-size: 20px;
            font-weight: 500;
            color: #2575fc;
            margin-bottom: 24px;
        }
        .date {
            font-size: 16px;
            color: #666;
            margin-bottom: 32px;
        }
        .footer {
            font-size: 14px;
            color: #888;
            margin-top: 32px;
        }
    </style>
</head>
<body>
    @php use Carbon\Carbon; @endphp

    <div class="certificate-box">
        <div class="title">SERTIFIKAT KOMPETENSI</div>
        <div class="subtitle">Diberikan kepada:</div>

        {{-- Nama user --}}
        <div class="name">{{ $user->name ?? 'Nama Tidak Diketahui' }}</div>

        <div class="subtitle">Sebagai bukti telah menyelesaikan uji kompetensi:</div>

        {{-- Nama kompetensi --}}
        <div class="kompetensi">{{ $kompetensi->title ?? 'Kompetensi Tidak Diketahui' }}</div>

        {{-- Tanggal selesai --}}
        <div class="date">
            Tanggal Selesai: 
            {{ !empty($completed_at) ? Carbon::parse($completed_at)->translatedFormat('d F Y') : '-' }}
        </div>

        <div class="footer">
            Pelaon &mdash; {{ date('Y') }}
        </div>
    </div>
</body>
</html>
