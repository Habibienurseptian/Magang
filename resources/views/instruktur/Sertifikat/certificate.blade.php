<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kompetensi</title>
    <style>
        @page {
            margin: 0cm;
            size: A4 landscape;
        /* Print styles */
        @media print {
            body {
                background-size: cover;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            
            .certificate-box {
                width: 58%;
                max-width: none;
                margin-top: 8%;
                margin-left: 2%;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background-image: url("{{ public_path('images/tmplte-sertifikat.jpg') }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
        }

        .certificate-box {
            /* Positioning untuk menyesuaikan area putih pada background */
            width: 58%;
            max-width: 650px;
            padding: 20px 40px;
            text-align: center;
            position: relative;
            /* Hapus background dan border karena sudah ada di image */
            background: transparent;
            border: none;
            box-shadow: none;
            /* Sesuaikan posisi vertikal jika diperlukan */
            margin-top: 20%;
            margin-left: 20%;
        }

        .title {
            font-size: 30px;
            font-weight: bold;
            color: #1a365d;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            line-height: 1.2;
        }

        .subtitle {
            font-size: 16px;
            color: #2d3748;
            margin-bottom: 8px;
            font-style: italic;
            font-weight: 500;
        }

        .name {
            font-size: 30px;
            font-weight: 700;
            color: #1a202c;
            margin: 12px 0;
            text-decoration: underline;
            text-decoration-color: #c6882a;
            text-underline-offset: 5px;
            text-decoration-thickness: 2px;
            line-height: 1.3;
        }

        .kompetensi {
            font-size: 22px;
            font-weight: 600;
            color: #1a365d;
            margin: 15px 0;
            padding: 8px 20px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 6px;
            border-left: 3px solid #c6882a;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(3px);
            line-height: 1.4;
        }

        .date {
            font-size: 15px;
            color: #4a5568;
            margin: 12px 0;
            font-weight: 500;
        }

        .footer {
            font-size: 15px;
            color: #c6882a;
            margin-top: 15px;
            font-style: italic;
            font-weight: 600;
        }

        .company-name {
            font-weight: 600;
            color: #c6882a;
        }

        /* Medal/Badge positioning - untuk menyelaraskan dengan badge di background */
        .achievement-badge {
            position: absolute;
            top: -10px;
            right: 10%;
            font-size: 15px;
            color: #c6882a;
            font-weight: bold;
            text-transform: uppercase;
            /* Sesuaikan posisi jika badge tidak tepat */
        }

        /* Fine-tuning untuk posisi konten */
        .content-wrapper {
            margin-top: 5px;
        }

        /* Styling khusus untuk setiap bagian */
        .name-section {
            margin: 20px 0;
            padding: 10px 0;
        }

        .achievement-section {
            margin: 20px 0;
        }

        .date-section {
            margin: 18px 0 15px 0;
        }

        .footer-section {
            margin-top: 20px;
            padding-top: 10px;
        }

        
        }
    </style>
</head>
<body>
    @php use Carbon\Carbon; @endphp

    <div class="certificate-box">
        <div class="content-wrapper">
            <div class="title">SERTIFIKAT KOMPETENSI</div>
            
            <div class="subtitle">Diberikan kepada:</div>

            <div class="name-section">
                <div class="name">{{ $user->name ?? 'Nama Tidak Diketahui' }}</div>
            </div>

            <div class="achievement-section">
                <div class="subtitle">Sebagai bukti telah menyelesaikan uji kompetensi:</div>
                <div class="kompetensi">{{ $kompetensi->title ?? 'Kompetensi Tidak Diketahui' }}</div>
            </div>

            <div class="date-section">
                <div class="date">
                    Tanggal Selesai: 
                    {{ !empty($completed_at) ? Carbon::parse($completed_at)->translatedFormat('d F Y') : '-' }}
                </div>
            </div>

            <div class="footer-section">
                <div class="footer">
                    <span class="company-name">SIPELON</span> &mdash; {{ date('Y') }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>