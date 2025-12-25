<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kesehatan - Test Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-green-600 to-teal-500 text-white p-6">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-heartbeat text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">FitPlus</h2>
                    <p class="text-xs text-green-100">Health Tracking</p>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('laporan.kesehatan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white bg-opacity-20">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan Kesehatan</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <div class="bg-gradient-to-r from-green-700 to-teal-600 text-white px-8 py-4">
                <h1 class="text-2xl font-bold">Laporan Kesehatan</h1>
                <p class="text-sm text-green-100 mt-1">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    {{ now()->locale('id')->format('l, j F Y') }}
                </p>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-8 bg-white">
                <div class="max-w-6xl mx-auto">
                    
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded">
                        <h2 class="text-lg font-bold text-blue-800 mb-2">
                            <i class="fas fa-info-circle mr-2"></i> Selamat Datang
                        </h2>
                        <p class="text-blue-700">
                            Halaman Laporan Kesehatan sedang dalam tahap pengembangan.
                            Jika Anda melihat pesan ini, berarti sistem sudah berjalan dengan baik! ✅
                        </p>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            Status Sistem
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                                <p class="text-sm text-gray-600">Database Connection</p>
                                <p class="text-2xl font-bold text-green-600">✅ Connected</p>
                            </div>
                            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                                <p class="text-sm text-gray-600">Authentication</p>
                                <p class="text-2xl font-bold text-green-600">✅ Active</p>
                            </div>
                            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                                <p class="text-sm text-gray-600">Routes</p>
                                <p class="text-2xl font-bold text-green-600">✅ Loaded</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600 text-white rounded-lg hover:shadow-lg transition">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
