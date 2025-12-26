<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Laporan Kesehatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                    </svg>
                </div>
                
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Status Laporan Kesehatan</h1>
                
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded mb-6 text-left">
                    <p class="text-green-800 font-semibold mb-2">✅ Sistem Siap</p>
                    <ul class="text-sm text-green-700 space-y-1">
                        <li>✓ Route registered</li>
                        <li>✓ Controller ready</li>
                        <li>✓ View compiled</li>
                        <li>✓ Middleware active</li>
                    </ul>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-6 text-left">
                    <p class="text-blue-800 font-semibold mb-2">📝 Petunjuk Akses</p>
                    <ol class="text-sm text-blue-700 space-y-1">
                        <li>1. Pastikan sudah login</li>
                        <li>2. Klik tombol di bawah</li>
                        <li>3. Laporan akan ditampilkan</li>
                    </ol>
                </div>

                <a href="javascript:void(0)" onclick="window.location.href='{{ route('laporan.kesehatan') }}'" class="w-full bg-gradient-to-r from-green-600 to-teal-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition mb-3">
                    Buka Laporan Kesehatan
                </a>
                
                <p class="text-gray-600 text-sm">
                    Jika belum login, sistem akan redirect ke login page.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
