<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan Pemesanan Tiket - Tabibito</title>
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
            box-shadow: 0 10px 30px rgba(245, 158, 11, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
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
        .info-card {
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 28px;
        }
        .info-title {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 16px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-row {
            border-bottom: 1px solid #f1f5f9;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-size: 13px;
            color: #64748b;
            padding: 10px 0;
            font-weight: 500;
        }
        .info-val {
            font-size: 13px;
            color: #1e293b;
            padding: 10px 0;
            text-align: right;
            font-weight: 700;
        }
        .total-price {
            font-size: 18px;
            color: #ea580c;
            font-weight: 800;
        }
        .btn-container {
            text-align: center;
            margin-bottom: 8px;
        }
        .btn {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff !important;
            padding: 14px 32px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.25);
            transition: all 0.2s ease-in-out;
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
                <h1 class="header-title">Invoice Pemesanan Tiket #{{ $transaction->order_id }}</h1>
            </div>
            <div class="content">
                <h2 class="greeting">Halo, {{ $transaction->user->name }}!</h2>
                <p class="lead-text">
                    Terima kasih telah melakukan pemesanan tiket wisata di **Tabibito**. Tiket Anda telah dipesan dan saat ini sedang menunggu penyelesaian pembayaran.
                </p>
                
                <div class="info-card">
                    <h3 class="info-title">Detail Pemesanan</h3>
                    <table class="info-table">
                        <tr class="info-row">
                            <td class="info-label">Order ID</td>
                            <td class="info-val" style="font-family: monospace;">{{ $transaction->order_id }}</td>
                        </tr>
                        <tr class="info-row">
                            <td class="info-label">Destinasi Wisata</td>
                            <td class="info-val">{{ $transaction->ticket->destination->name }}</td>
                        </tr>
                        <tr class="info-row">
                            <td class="info-label">Jenis Tiket</td>
                            <td class="info-val">{{ $transaction->ticket->name }}</td>
                        </tr>
                        <tr class="info-row">
                            <td class="info-label">Tanggal Kunjungan</td>
                            <td class="info-val">{{ $transaction->booking_date->format('d F Y') }}</td>
                        </tr>
                        <tr class="info-row">
                            <td class="info-label">Jumlah Tiket</td>
                            <td class="info-val">{{ $transaction->qty }} Tiket</td>
                        </tr>
                        <tr class="info-row">
                            <td class="info-label">Status Pembayaran</td>
                            <td class="info-val" style="color: #ea580c; text-transform: uppercase;">PENDING</td>
                        </tr>
                        <tr class="info-row">
                            <td class="info-label" style="font-weight: 700; color: #1e293b; font-size: 14px; padding-top: 14px;">Total Tagihan</td>
                            <td class="info-val total-price" style="padding-top: 14px;">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="btn-container">
                    <a href="{{ route('checkout.resume', ['order_id' => $transaction->order_id]) }}" class="btn">Lanjutkan Pembayaran</a>
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
