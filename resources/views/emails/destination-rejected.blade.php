<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Destinasi Ditolak — Tabibito</title>
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
            box-shadow: 0 10px 30px rgba(244, 63, 94, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 50%, #be123c 100%);
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
        .header-title { font-size: 24px; font-weight: 800; margin: 0; line-height: 1.3; }
        .header-sub { font-size: 14px; margin: 12px 0 0; opacity: 0.92; }
        .content { padding: 40px; }
        .greeting { font-size: 20px; color: #0f172a; font-weight: 700; margin: 0 0 12px 0; }
        .lead-text { font-size: 15px; color: #475569; line-height: 1.75; margin: 0 0 24px 0; }
        .destination-mini {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 20px 0;
            padding: 12px 16px;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid #f43f5e;
        }
        .reason-card {
            background: linear-gradient(145deg, #fff1f2 0%, #ffe4e6 100%);
            border: 1px solid #fecdd3;
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 28px;
        }
        .reason-label {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #be123c;
            margin: 0 0 12px 0;
        }
        .reason-text {
            font-size: 15px;
            color: #881337;
            line-height: 1.65;
            margin: 0;
            font-weight: 500;
        }
        .action-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 22px 24px;
            margin-bottom: 32px;
            font-size: 14px;
            color: #475569;
            line-height: 1.65;
        }
        .action-card strong { color: #0f172a; }
        .btn-container { text-align: center; margin-bottom: 8px; }
        .btn {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: #ffffff !important;
            padding: 16px 36px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
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
                <div class="header-icon">📋</div>
                <h1 class="header-title">Pengajuan Perlu Perbaikan</h1>
                <p class="header-sub">Destinasi belum dapat disetujui saat ini</p>
            </div>

            <div class="content">
                <h2 class="greeting">Halo, {{ $owner?->name ?? 'Mitra' }}!</h2>
                <p class="lead-text">
                    Setelah ditinjau, pengajuan destinasi wisata Anda belum dapat kami setujui.
                    Jangan khawatir — Anda dapat memperbaiki data dan mengajukan ulang kapan saja.
                </p>

                <p class="destination-mini">
                    🏞️ <strong>{{ $destination->name }}</strong> — {{ $destination->city }}
                </p>

                <div class="reason-card">
                    <p class="reason-label">Alasan dari administrator</p>
                    <p class="reason-text">{{ $rejectionReason }}</p>
                </div>

                <div class="action-card">
                    Buka panel owner, perbaiki data sesuai catatan di atas, lalu tekan tombol
                    <strong>Simpan dan Ajukan Ulang</strong>. Tim admin akan meninjau ulang pengajuan Anda.
                </div>

                <div class="btn-container">
                    <a href="{{ route('owner.destinations.index') }}" class="btn">Perbaiki di Panel Destinasi</a>
                </div>

                <p style="font-size:13px;color:#94a3b8;text-align:center;margin-top:24px;">
                    Butuh bantuan? Hubungi kami melalui halaman kontak di website Tabibito.
                </p>
            </div>

            <div class="footer">
                <p class="footer-brand">TABIBITO JAWA TENGAH</p>
                <p class="footer-text">
                    Email otomatis — pemberitahuan penolakan pengajuan destinasi.<br>
                    &copy; {{ date('Y') }} Tabibito. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
