<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinasi Disetujui — Tabibito</title>
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
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.12);
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
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
        .header-icon { font-size: 48px; line-height: 1; margin-bottom: 12px; }
        .header-title {
            font-size: 26px;
            font-weight: 800;
            margin: 0;
            line-height: 1.25;
        }
        .header-sub { font-size: 14px; margin: 12px 0 0; opacity: 0.92; }
        .content { padding: 40px; }
        .greeting { font-size: 20px; color: #0f172a; font-weight: 700; margin: 0 0 12px 0; }
        .lead-text { font-size: 15px; color: #475569; line-height: 1.75; margin: 0 0 28px 0; }
        .success-card {
            background: linear-gradient(145deg, #ecfdf5 0%, #d1fae5 100%);
            border: 1px solid #a7f3d0;
            border-radius: 20px;
            padding: 32px 28px;
            margin-bottom: 28px;
            text-align: center;
        }
        .success-label {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #059669;
            margin: 0 0 12px 0;
        }
        .success-name {
            font-size: 24px;
            font-weight: 800;
            color: #065f46;
            margin: 0 0 8px 0;
            line-height: 1.3;
        }
        .success-city { font-size: 14px; color: #047857; font-weight: 600; margin: 0 0 16px 0; }
        .live-badge {
            display: inline-block;
            background: #10b981;
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 8px 18px;
            border-radius: 50px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }
        .tips-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 22px 24px;
            margin-bottom: 32px;
        }
        .tips-title { font-size: 13px; font-weight: 800; color: #1e293b; margin: 0 0 12px 0; }
        .tips-list { margin: 0; padding: 0 0 0 18px; color: #475569; font-size: 14px; line-height: 1.7; }
        .btn-row { text-align: center; margin-bottom: 8px; }
        .btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff !important;
            padding: 14px 28px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            margin: 4px;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }
        .btn-secondary {
            background: #ffffff;
            color: #059669 !important;
            border: 2px solid #10b981;
            box-shadow: none;
        }
        .footer {
            padding: 28px 40px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }
        .footer-text { font-size: 12px; color: #94a3b8; line-height: 1.6; margin: 0; }
        .footer-brand { font-size: 13px; font-weight: 800; color: #64748b; margin: 0 0 8px 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <span class="logo-text">Tabibito Jateng</span>
                <div class="header-icon">✅</div>
                <h1 class="header-title">Pengajuan Disetujui!</h1>
                <p class="header-sub">Destinasi Anda kini aktif di katalog</p>
            </div>

            <div class="content">
                <h2 class="greeting">Halo, {{ $owner?->name ?? 'Mitra' }}!</h2>
                <p class="lead-text">
                    Kabar gembira! Tim administrator telah <strong>menyetujui</strong> destinasi wisata Anda.
                    Sekarang traveler dapat menemukan dan memesan tiket langsung melalui platform Tabibito.
                </p>

                <div class="success-card">
                    <p class="success-label">Destinasi aktif</p>
                    <h3 class="success-name">{{ $destination->name }}</h3>
                    <p class="success-city">📍 {{ $destination->city }}, Jawa Tengah</p>
                    <span class="live-badge">🎉 Siap Dipesan</span>
                </div>

                <div class="tips-card">
                    <p class="tips-title">💡 Tips memulai penjualan</p>
                    <ul class="tips-list">
                        <li>Atur <strong>paket tiket</strong> dan <strong>kuota harian</strong> di panel owner.</li>
                        <li>Siapkan <strong>scanner QR</strong> untuk petugas di lokasi wisata.</li>
                        <li>Gunakan <strong>Mode Perawatan</strong> jika tutup sementara tanpa hapus data.</li>
                        <li>Pantau pendapatan dan unduh laporan CSV dari dashboard owner.</li>
                    </ul>
                </div>

                <div class="btn-row">
                    <a href="{{ route('owner.dashboard') }}" class="btn">Buka Dashboard Owner</a>
                    <a href="{{ route('destinations.show', $destination) }}" class="btn btn-secondary">Lihat di Katalog</a>
                </div>
            </div>

            <div class="footer">
                <p class="footer-brand">TABIBITO JAWA TENGAH</p>
                <p class="footer-text">
                    Email otomatis — pemberitahuan persetujuan destinasi.<br>
                    &copy; {{ date('Y') }} Tabibito. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
