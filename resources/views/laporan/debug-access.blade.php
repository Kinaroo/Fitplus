<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kesehatan - Akses Alternatif</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">🔧 Debug Laporan Kesehatan</h1>
            
            <div class="space-y-6">
                <!-- Status Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Login Status</p>
                        <p class="text-2xl font-bold text-blue-600">
                            @if(auth()->check())
                                ✅ YES
                            @else
                                ❌ NO
                            @endif
                        </p>
                    </div>
                    
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">User</p>
                        <p class="text-xl font-bold text-green-600">
                            {{ auth()->user()?->nama ?? 'Guest' }}
                        </p>
                    </div>
                </div>

                <!-- Session Info -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-300">
                    <p class="font-semibold text-gray-700 mb-2">Session Info:</p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>Session ID: <code class="bg-white px-2 py-1">{{ session()->getId() }}</code></li>
                        <li>Auth Guard: <code class="bg-white px-2 py-1">{{ config('auth.defaults.guard') }}</code></li>
                        <li>Session Driver: <code class="bg-white px-2 py-1">{{ config('session.driver') }}</code></li>
                    </ul>
                </div>

                <!-- If Authenticated, show laporan button -->
                @if(auth()->check())
                    <div class="bg-green-100 border-l-4 border-green-500 p-4 rounded">
                        <p class="text-green-800 font-semibold mb-3">✅ Sudah Login</p>
                        <a href="{{ route('laporan.kesehatan') }}" class="inline-block px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                            📊 Buka Laporan Kesehatan
                        </a>
                    </div>
                @else
                    <div class="bg-red-100 border-l-4 border-red-500 p-4 rounded">
                        <p class="text-red-800 font-semibold mb-3">❌ Belum Login</p>
                        <p class="text-red-700 mb-3">Silakan login terlebih dahulu:</p>
                        <form action="{{ route('login') }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="email" name="email" value="niki@fitplus.com" placeholder="Email" class="w-full border border-gray-300 rounded px-4 py-2 required">
                            <input type="password" name="password" value="12345678" placeholder="Password" class="w-full border border-gray-300 rounded px-4 py-2 required">
                            <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                                🔐 Login
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Alternative Access -->
                <div class="bg-orange-50 p-4 rounded-lg border-l-4 border-orange-500">
                    <p class="font-semibold text-orange-800 mb-2">🔗 Akses Alternatif:</p>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('dashboard') }}" class="text-orange-600 hover:underline">Dashboard</a></li>
                        <li><a href="{{ route('makanan.harian') }}" class="text-orange-600 hover:underline">Pelacak Nutrisi</a></li>
                        <li><a href="{{ route('tidur.analisis') }}" class="text-orange-600 hover:underline">Pelacak Tidur</a></li>
                    </ul>
                </div>

                <!-- Clear Cache Info -->
                <div class="bg-gray-900 text-white p-4 rounded-lg text-sm">
                    <p class="font-semibold mb-2">💡 Jika masih tidak bisa:</p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Buka DevTools (F12)</li>
                        <li>Buka tab "Application" atau "Storage"</li>
                        <li>Delete semua cookies untuk localhost:8000</li>
                        <li>Refresh page (Ctrl+F5)</li>
                        <li>Login ulang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
