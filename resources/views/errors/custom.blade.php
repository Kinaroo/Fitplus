<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-red-50 to-orange-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl p-8 max-w-md w-full">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Error {{ $code ?? 500 }}</h1>
                
                <p class="text-gray-600 mb-6">
                    {{ $message ?? 'Terjadi kesalahan saat memproses permintaan Anda.' }}
                </p>

                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="block px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600 text-white rounded-lg hover:shadow-lg transition font-semibold">
                        Kembali ke Dashboard
                    </a>
                    <button onclick="history.back()" class="w-full px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Kembali
                    </button>
                </div>

                <p class="text-xs text-gray-400 mt-6">
                    Error ID: {{ session()->getId() }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>
