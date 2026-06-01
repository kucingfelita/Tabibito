<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang Mitra Tabibito</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper { width: 100%; background-color: #f8fafc; padding: 40px 20px; }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(14, 165, 233, 0.12);
        }
        .header {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);
            padding: 48px 40px;
            text-align: center;
            color: #ffffff;
        }
        .logo-text {
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.12em;
            margin: 0 0 20px 0;
            text-transform: uppercase;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 18px;
            border-radius: 50px;
            display: inline-block;
            border: 1px solid rgba(255, 255, 255, 0.35);
        }
        .header-icon {
            font-size: 48px;
            line-height: 1;
            margin-bottom: 12px;
        }
        .header-title {
            font-size: 26px;
            font-weight: 800;
            margin: 0;
            line-height: 1.25;
            letter-spacing: -0.02em;
        }
        .header-sub {
            font-size: 14px;
            margin: 12px 0 0;
            opacity: 0.92;
            font-weight: 500;
        }
        .content { padding: 40px; }
        .greeting {
            font-size: 20px;
            color: #0f172a;
            font-weight: 700;
            margin: 0 0 12px 0;
        }
        .lead-text {
            font-size: 15px;
            color: #475569;
            line-height: 1.75;
            margin: 0 0 28px 0;
        }
        .destination-card {
            background: linear-gradient(145deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 28px;
            text-align: center;
        }
        .destination-label {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #0369a1;
            margin: 0 0 10px 0;
        }
        .destination-name {
            font-size: 22px;
            font-weight: 800;
            color: #0c4a6e;
            margin: 0 0 6px 0;
            line-height: 1.3;
        }
        .destination-city {
            font-size: 14px;
            color: #0284c7;
            font-weight: 600;
            margin: 0 0 16px 0;
        }
        .status-badge {
            display: inline-block;
            background: #fef3c7;
            color: #b45309;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 8px 16px;
            border-radius: 50px;
            border: 1px solid #fde68a;
        }
        .steps-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px 28px;
            margin-bottom: 32px;
        }
        .steps-title {
            font-size: 13px;
            font-weight: 800;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin: 0 0 16px 0;
        }
        .step-item {
            display: table;
            width: 100%;
            margin-bottom: 14px;
        }
        .step-item:last-child { margin-bottom: 0; }
        .step-num {
            display: table-cell;
            width: 32px;
            vertical-align: top;
            font-size: 12px;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            width: 28px;
            height: 28px;
            line-height: 28px;
            text-align: center;
            border-radius: 8px;
        }
        .step-text {
            display: table-cell;
            padding-left: 14px;
            vertical-align: top;
            font-size: 14px;
            color: #475569;
            line-height: 1.55;
        }
        .account-hint {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 16px 20px;
            font-size: 13px;
            color: #64748b;
            text-align: center;
            margin-bottom: 28px;
        }
        .account-hint strong { color: #0f172a; }
        .btn-container { text-align: center; margin-bottom: 8px; }
        .btn {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: #ffffff !important;
            padding: 16px 40px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.35);
        }
        .footer {
            padding: 28px 40px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }
        .footer-text {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.6;
            margin: 0;
        }
        .footer-brand {
            font-size: 13px;
            font-weight: 800;
            color: #64748b;
            margin: 0 0 8px 0;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <span class="logo-text">Tabibito Jateng</span>
                <div class="header-icon">🤝</div>
                <h1 class="header-title">Selamat Datang,<br>Mitra Wisata!</h1>
                <p class="header-sub">Pendaftaran Anda berhasil kami terima</p>
            </div>

            <div class="content">
                <h2 class="greeting">Halo, {{ $user->name }}!</h2>
                <p class="lead-text">
                    Terima kasih telah bergabung sebagai <strong>mitra pengelola destinasi wisata</strong> di Tabibito Jawa Tengah.
                    Akun owner Anda sudah aktif dan pengajuan destinasi sedang menunggu tinjauan tim kami.
                </p>

                <div class="destination-card">
                    <p class="destination-label">Destinasi yang diajukan</p>
                    <h3 class="destination-name">{{ $destination->name }}</h3>
                    <p class="destination-city">📍 {{ $destination->city }}, Jawa Tengah</p>
                    <span class="status-badge">⏳ Menunggu Verifikasi Admin</span>
                </div>

                <div class="steps-card">
                    <p class="steps-title">Langkah selanjutnya</p>
                    <div class="step-item">
                        <span class="step-num">1</span>
                        <span class="step-text">Tim admin meninjau foto, deskripsi, dan kelengkapan data destinasi Anda.</span>
                    </div>
                    <div class="step-item">
                        <span class="step-num">2</span>
                        <span class="step-text">Setelah disetujui, destinasi tampil di katalog dan traveler bisa memesan tiket.</span>
                    </div>
                    <div class="step-item">
                        <span class="step-num">3</span>
                        <span class="step-text">Anda akan menerima email saat pengajuan disetujui atau jika perlu perbaikan.</span>
                    </div>
                    <div class="step-item">
                        <span class="step-num">4</span>
                        <span class="step-text">Kelola paket tiket, scanner QR, dan pencairan dana lewat panel owner.</span>
                    </div>
                </div>

                <div class="account-hint">
                    Username akun Anda: <strong>{{ $user->username }}</strong><br>
                    Gunakan email ini untuk login setelah destinasi disetujui.
                </div>

                <div class="btn-container">
                    <a href="{{ route('login') }}" class="btn">Masuk ke Panel Owner</a>
                </div>
            </div>

            <div class="footer">
                <p class="footer-brand">TABIBITO JAWA TENGAH</p>
                <p class="footer-text">
                    Email ini dikirim otomatis setelah pendaftaran mitra.<br>
                    Mohon tidak membalas langsung ke alamat ini.<br>
                    &copy; {{ date('Y') }} Tabibito. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
