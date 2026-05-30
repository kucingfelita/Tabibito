<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket Tabibito Anda</title>
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
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 40px;
            text-align: center;
            color: #ffffff;
        }
        .logo-text {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0 0 12px 0;
            text-transform: uppercase;
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 14px;
            border-radius: 50px;
            display: inline-block;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
        .header-title {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            line-height: 1.3;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 18px;
            color: #0f172a;
            font-weight: 700;
            margin: 0 0 12px 0;
        }
        .lead-text {
            font-size: 14px;
            color: #475569;
            line-height: 1.6;
            margin: 0 0 28px 0;
        }
        
        /* Dashed Ticket Card */
        .ticket-card {
            border: 2px dashed #a7f3d0;
            background-color: #f0fdf4;
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 28px;
            position: relative;
        }
        .ticket-title {
            font-size: 16px;
            font-weight: 800;
            color: #065f46;
            margin: 0 0 20px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
        }
        .ticket-table {
            width: 100%;
            border-collapse: collapse;
        }
        .ticket-row {
            border-bottom: 1px dashed #d1fae5;
        }
        .ticket-row:last-child {
            border-bottom: none;
        }
        .ticket-label {
            font-size: 13px;
            color: #047857;
            padding: 12px 0;
            font-weight: 600;
        }
        .ticket-val {
            font-size: 13px;
            color: #064e3b;
            padding: 12px 0;
            text-align: right;
            font-weight: 800;
        }
        
        /* QR Code Container */
        .qr-section {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 2px dashed #a7f3d0;
        }
        .qr-wrapper {
            background-color: #ffffff;
            border: 2px solid #e2e8f0;
            padding: 16px;
            border-radius: 16px;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            margin-bottom: 16px;
        }
        .manual-code {
            font-family: monospace;
            font-size: 14px;
            font-weight: 800;
            color: #047857;
            background-color: #d1fae5;
            padding: 6px 14px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 8px;
        }
        .warning-text {
            font-size: 12px;
            color: #065f46;
            margin: 12px 0 0 0;
            font-weight: 500;
        }

        .btn-container {
            text-align: center;
            margin-top: 8px;
        }
        .btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff !important;
            padding: 14px 32px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.25);
        }
        .footer {
            padding: 32px 40px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }
        .footer-text {
            font-size: 12px;
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
                <h1 class="header-title">E-Tiket Wisata Anda Sudah Aktif!</h1>
            </div>
            <div class="content">
                <h2 class="greeting">Halo, {{ $transaction->user->name }}! 🎉</h2>
                <p class="lead-text">
                    Pembayaran Anda telah sukses diverifikasi! Tiket digital Anda kini telah aktif dan siap digunakan untuk masuk ke lokasi destinasi pilihan Anda.
                </p>
                
                <div class="ticket-card">
                    <h3 class="ticket-title">🎟️ E-TICKET DIGITAL</h3>
                    <table class="ticket-table">
                        <tr class="ticket-row">
                            <td class="ticket-label">Order ID</td>
                            <td class="ticket-val" style="font-family: monospace;">{{ $transaction->order_id }}</td>
                        </tr>
                        <tr class="ticket-row">
                            <td class="ticket-label">Nama Pengunjung</td>
                            <td class="ticket-val">{{ $transaction->user->name }}</td>
                        </tr>
                        <tr class="ticket-row">
                            <td class="ticket-label">Destinasi Wisata</td>
                            <td class="ticket-val">{{ $transaction->ticket->destination->name }}</td>
                        </tr>
                        <tr class="ticket-row">
                            <td class="ticket-label">Jenis Tiket</td>
                            <td class="ticket-val">{{ $transaction->ticket->name }}</td>
                        </tr>
                        <tr class="ticket-row">
                            <td class="ticket-label">Tanggal Kunjungan</td>
                            <td class="ticket-val">{{ $transaction->booking_date->format('d F Y') }}</td>
                        </tr>
                        <tr class="ticket-row">
                            <td class="ticket-label">Jumlah Tiket</td>
                            <td class="ticket-val" style="color: #047857;">{{ $transaction->qty }} Orang</td>
                        </tr>
                    </table>
                    
                    <div class="qr-section">
                        @php
                            try {
                                $qrCode = 'data:image/png;base64,' . base64_encode(QrCode::format('png')->size(200)->generate($transaction->qr_code_token));
                            } catch (\Throwable $e) {
                                $qrCode = null;
                            }
                        @endphp
                        
                        <div class="qr-wrapper">
                            @if($qrCode)
                                <img src="{{ $qrCode }}" width="200" height="200" style="display: block; outline: none; border: none;" alt="QR Code">
                            @else
                                <div style="display: inline-block;">
                                    {!! QrCode::size(200)->generate($transaction->qr_code_token) !!}
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="warning-text">Tunjukkan QR Code di atas atau kode manual berikut kepada petugas loket:</p>
                            <span class="manual-code">{{ $transaction->qr_code_token }}</span>
                        </div>
                    </div>
                </div>

                <div class="btn-container">
                    <a href="{{ route('history.index') }}" class="btn">Lihat Riwayat Transaksi</a>
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
