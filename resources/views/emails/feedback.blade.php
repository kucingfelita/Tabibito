<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Baru Dari Kontak Pengguna</title>
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
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
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
            background: rgba(255, 255, 255, 0.1);
            padding: 6px 14px;
            border-radius: 50px;
            display: inline-block;
            border: 1px solid rgba(255, 255, 255, 0.2);
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
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .meta-row {
            border-bottom: 1px solid #f1f5f9;
        }
        .meta-label {
            font-size: 14px;
            font-weight: 700;
            color: #64748b;
            padding: 14px 0;
            width: 30%;
        }
        .meta-value {
            font-size: 14px;
            color: #1e293b;
            padding: 14px 0;
            font-weight: 500;
        }
        .message-title {
            font-size: 14px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 32px 0 12px 0;
        }
        .message-box {
            background-color: #f8fafc;
            border-left: 4px solid #4f46e5;
            border-radius: 0 16px 16px 0;
            padding: 24px;
            font-size: 15px;
            color: #334155;
            line-height: 1.7;
            margin: 0 0 32px 0;
            font-style: italic;
        }
        .btn-container {
            text-align: center;
        }
        .btn {
            background: #4f46e5;
            color: #ffffff !important;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.2);
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
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <span class="logo-text">TABIBITO ADMIN</span>
                <h1 class="header-title">📬 Anda Menerima Pesan Baru</h1>
            </div>
            <div class="content">
                <table class="meta-table">
                    <tr class="meta-row">
                        <td class="meta-label">Nama Pengirim</td>
                        <td class="meta-value">{{ $name }}</td>
                    </tr>
                    <tr class="meta-row">
                        <td class="meta-label">Alamat Email</td>
                        <td class="meta-value">
                            <a href="mailto:{{ $email }}" style="color: #4f46e5; text-decoration: none;">{{ $email }}</a>
                        </td>
                    </tr>
                </table>
                
                <h3 class="message-title">Isi Pesan:</h3>
                <div class="message-box">
                    "{!! nl2br(e($message)) !!}"
                </div>

                <div class="btn-container">
                    <a href="mailto:{{ $email }}" class="btn">Balas Pesan Pengguna</a>
                </div>
            </div>
            <div class="footer">
                <p class="footer-text">
                    Email ini dikirimkan otomatis oleh sistem admin Tabibito.<br>
                    &copy; 2026 Tabibito. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>