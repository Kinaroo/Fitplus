<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Login & Laporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Test Login & Laporan Kesehatan</h1>
            
            <div class="space-y-4">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <h2 class="font-bold text-blue-800 mb-2">Step 1: Login</h2>
                    <p class="text-blue-700 mb-3">Gunakan kredensial untuk login:</p>
                    <form action="{{ route('login') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="email" name="email" value="niki@fitplus.com" placeholder="Email" class="w-full border border-gray-300 rounded px-4 py-2" required>
                        <input type="password" name="password" value="12345678" placeholder="Password" class="w-full border border-gray-300 rounded px-4 py-2" required>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Login
                        </button>
                    </form>
                </div>

                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <h2 class="font-bold text-green-800 mb-2">Step 2: Akses Laporan</h2>
                    <p class="text-green-700 mb-3">Setelah login, klik tombol di bawah untuk buka laporan:</p>
                    <a href="{{ route('laporan.kesehatan') }}" class="inline-block px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Buka Laporan Kesehatan
                    </a>
                </div>

                <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded">
                    <h2 class="font-bold text-orange-800 mb-2">Status</h2>
                    <p class="text-orange-700">
                        @if(auth()->check())
                            ✅ Sudah login sebagai: <strong>{{ auth()->user()->nama }}</strong>
                        @else
                            ❌ Belum login
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-6 text-white">
            <h3 class="font-bold mb-3">Akun Tersedia:</h3>
            <ul class="space-y-2 text-sm">
                <li>📧 niki@fitplus.com | 🔑 12345678</li>
                <li>📧 rany@fitplus.com | 🔑 12345678</li>
                <li>📧 dina@fitplus.com | 🔑 12345678</li>
                <li>📧 toni@fitplus.com | 🔑 12345678</li>
            </ul>
        </div>
    </div>
</body>
</html>
