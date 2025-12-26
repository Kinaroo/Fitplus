<!DOCTYPE html>
<html>
<head>
    <title>Laporan Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Status Laporan Kesehatan</h1>
        
        @if(!isset($user) || !$user)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <p class="font-bold">⚠️ Tidak Ada User</p>
                <p>User tidak ter-pass ke view. Redirect ke login...</p>
            </div>
        @else
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <p class="font-bold">✅ User Terdeteksi</p>
                <p>Nama: <strong>{{ $user->nama }}</strong></p>
                <p>Email: <strong>{{ $user->email }}</strong></p>
            </div>
            
            @if(!isset($stats))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                    <p>⚠️ Stats tidak ada</p>
                </div>
            @else
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                    <p class="font-bold">📊 Stats Available</p>
                    <p>Berat hari ini: {{ $stats['berat_hari'] ?? '-' }}</p>
                </div>
            @endif
        @endif
        
        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>
