<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Tabibito</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .wrapper {
            width: 100%;
            background-color: #f8fafc;
            padding: 40px 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            padding: 48px 40px;
            text-align: center;
            color: #ffffff;
        }
        .logo-text {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0 0 16px 0;
            text-transform: uppercase;
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 16px;
            border-radius: 50px;
            display: inline-block;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .header-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            line-height: 1.3;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 20px;
            color: #0f172a;
            font-weight: 700;
            margin: 0 0 16px 0;
        }
        .lead-text {
            font-size: 16px;
            color: #475569;
            line-height: 1.7;
            margin: 0 0 32px 0;
        }
        .feature-card {
            background-color: #f1f5f9;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
        }
        .feature-item {
            margin-bottom: 20px;
        }
        .feature-item:last-child {
            margin-bottom: 0;
        }
        .feature-title {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 4px 0;
        }
        .feature-desc {
            font-size: 13px;
            color: #64748b;
            margin: 0;
            line-height: 1.5;
        }
        .btn-container {
            text-align: center;
            margin-bottom: 8px;
        }
        .btn {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            color: #ffffff !important;
            padding: 16px 36px;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.25);
            transition: all 0.2s ease-in-out;
        }
        .footer {
            padding: 32px 40px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }
        .footer-text {
            font-size: 13px;
            color: #94a3b8;
            line-height: 1.5;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <span class="logo-text">TABIBITO</span>
                <h1 class="header-title">Selamat datang di petualangan baru Anda!</h1>
            </div>
            <div class="content">
                <h2 class="greeting">Halo, {{ $user->name }}! 👋</h2>
                <p class="lead-text">
                    Terima kasih telah bergabung di **Tabibito**. Kami sangat senang dapat menjadi bagian dari perjalanan eksplorasi wisata Anda. Di sini, liburan impian Anda hanya sejauh beberapa klik saja!
                </p>
                
                <div class="feature-card">
                    <div class="feature-item">
                        <h3 class="feature-title">🗺️ Eksplorasi Destinasi Terbaik</h3>
                        <p class="feature-desc">Temukan ribuan tempat wisata menakjubkan dengan detail lengkap, foto indah, dan ulasan terpercaya.</p>
                    </div>
                    <div class="feature-item" style="border-top: 1px solid #e2e8f0; padding-top: 16px; margin-top: 16px;">
                        <h3 class="feature-title">⚡ Pesan Instan & Mudah</h3>
                        <p class="feature-desc">Pesan tiket secara online dalam hitungan detik tanpa perlu mengantre di lokasi wisata.</p>
                    </div>
                    <div class="feature-item" style="border-top: 1px solid #e2e8f0; padding-top: 16px; margin-top: 16px;">
                        <h3 class="feature-title">📱 QR Code Check-in</h3>
                        <p class="feature-desc">Cukup tunjukkan QR Code tiket digital langsung dari riwayat transaksi Anda kepada petugas saat tiba.</p>
                    </div>
                </div>

                <div class="btn-container">
                    <a href="{{ url('/') }}" class="btn">Mulai Jelajah Destinasi</a>
                </div>
            </div>
            <div class="footer">
                <p class="footer-text">
                    Email ini dikirimkan otomatis oleh Tabibito.<br>
                    &copy; 2026 Tabibito. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
