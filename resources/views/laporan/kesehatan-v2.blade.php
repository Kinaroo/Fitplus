<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kesehatan - FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-green-600 to-teal-500 text-white p-6 overflow-y-auto">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-heartbeat text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">FitPlus</h2>
                    <p class="text-xs text-green-100">Kesehatan Terjaga</p>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('laporan.kesehatan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white bg-opacity-20">
                    <i class="fas fa-chart-bar"></i>
                    <span class="font-semibold">Laporan Kesehatan</span>
                </a>
            </nav>

            <div class="mt-auto pt-6 border-t border-green-400 border-opacity-30">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-500 hover:bg-opacity-20 text-left">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <div class="bg-gradient-to-r from-green-700 to-teal-600 text-white px-8 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">Laporan Kesehatan</h1>
                        <p class="text-sm text-green-100 mt-1">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            {{ now()->locale('id')->format('l, j F Y') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold">{{ $user->nama ?? 'User' }}</p>
                        <p class="text-sm text-green-100">{{ $user->email ?? '' }}</p>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <!-- Stat Cards -->
                        <div class="bg-white rounded-lg p-4 shadow">
                            <div class="text-sm text-gray-500 mb-1">Berat Hari Ini</div>
                            <div class="text-2xl font-bold text-green-600">{{ $stats['berat_hari'] ?? '-' }}</div>
                        </div>
                        
                        <div class="bg-white rounded-lg p-4 shadow">
                            <div class="text-sm text-gray-500 mb-1">Tidur Hari Ini</div>
                            <div class="text-2xl font-bold text-blue-600">{{ $stats['tidur_hari'] ?? '-' }}</div>
                        </div>
                        
                        <div class="bg-white rounded-lg p-4 shadow">
                            <div class="text-sm text-gray-500 mb-1">Olahraga Hari Ini</div>
                            <div class="text-2xl font-bold text-orange-600">{{ $stats['olahraga_hari'] ?? 0 }} menit</div>
                        </div>
                        
                        <div class="bg-white rounded-lg p-4 shadow">
                            <div class="text-sm text-gray-500 mb-1">Kalori Hari Ini</div>
                            <div class="text-2xl font-bold text-red-600">{{ $stats['kalori_hari'] ?? 0 }}</div>
                        </div>
                    </div>

                    <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded">
                        <h2 class="text-lg font-bold text-green-800 mb-2">
                            <i class="fas fa-check-circle mr-2"></i> Sistem Siap
                        </h2>
                        <p class="text-green-700">
                            Laporan kesehatan sedang mengambil data. Jika data kosong, tambahkan data di menu lain terlebih dahulu.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
