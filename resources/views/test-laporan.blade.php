<!DOCTYPE html>
<html>
<head>
    <title>Test Laporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">TEST LAPORAN KESEHATAN</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Unauthenticated Access -->
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded">
                <h2 class="text-xl font-bold text-red-800 mb-4">Akses Tanpa Login</h2>
                <p class="text-red-700 mb-4">Klik tombol di bawah untuk test akses tanpa login:</p>
                <a href="{{ route('laporan.kesehatan') }}" class="inline-block px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Test (harusnya redirect ke login)
                </a>
            </div>
            
            <!-- Session Test -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded">
                <h2 class="text-xl font-bold text-blue-800 mb-4">Session Status</h2>
                <p class="text-blue-700 mb-2">Auth Check: <strong>{{ auth()->check() ? '✅ YES' : '❌ NO' }}</strong></p>
                <p class="text-blue-700 mb-4">User ID: <strong>{{ auth()->id() ?? 'None' }}</strong></p>
                <a href="{{ route('login.form') }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Go to Login
                </a>
            </div>
        </div>
        
        <div class="mt-8 p-6 bg-gray-50 border-l-4 border-gray-500 rounded">
            <h2 class="text-lg font-bold text-gray-800 mb-3">📋 Instruksi:</h2>
            <ol class="text-gray-700 space-y-2">
                <li><strong>1.</strong> Klik "Go to Login" di kanan</li>
                <li><strong>2.</strong> Login dengan akun Anda</li>
                <li><strong>3.</strong> Kembali ke halaman ini</li>
                <li><strong>4.</strong> Sekarang akses laporan dengan tombol merah</li>
            </ol>
        </div>
    </div>
</body>
</html>
