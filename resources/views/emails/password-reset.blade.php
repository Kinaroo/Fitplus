<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitPlus - Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #06b6d4;
        }
        .header h1 {
            color: #0d9488;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 15px;
        }
        .button {
            display: inline-block;
            background-color: #06b6d4;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
            text-align: center;
        }
        .button:hover {
            background-color: #0891b2;
        }
        .link-section {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            word-break: break-all;
        }
        .link-section p {
            margin: 5px 0;
            font-size: 12px;
        }
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px;
            margin: 20px 0;
            border-radius: 3px;
        }
        .warning p {
            margin: 0;
            color: #92400e;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            color: #999;
            font-size: 12px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>❤️ FitPlus</h1>
            <p>Reset Password</p>
        </div>

        <div class="content">
            <div class="greeting">
                <p>Halo <strong>{{ $userName }}</strong>,</p>
            </div>

            <p>Kami menerima permintaan untuk mereset password akun FitPlus Anda. Jika ini adalah permintaan Anda, silakan klik tombol di bawah untuk melanjutkan:</p>

            <div style="text-align: center;">
                <a href="{{ $resetLink }}" class="button">Reset Password Saya</a>
            </div>

            <p>Atau salin dan tempel link berikut di browser Anda:</p>

            <div class="link-section">
                <p><strong>Reset Link:</strong></p>
                <p>{{ $resetLink }}</p>
            </div>

            <div class="warning">
                <p>⏱️ <strong>Penting:</strong> Link reset ini hanya berlaku selama <strong>1 jam</strong>. Jika waktu telah habis, silakan minta link baru.</p>
            </div>

            <p>Jika Anda tidak meminta reset password, abaikan email ini dan tidak ada yang perlu dilakukan. Akun Anda tetap aman.</p>

            <p><strong>Catatan Keamanan:</strong> Jangan pernah membagikan link reset ini kepada siapa pun.</p>
        </div>

        <div class="footer">
            <p>&copy; 2025 FitPlus - Aplikasi Pelacak Kesehatan</p>
            <p>Jika Anda memiliki pertanyaan, hubungi support kami.</p>
        </div>
    </div>
</body>
</html>
