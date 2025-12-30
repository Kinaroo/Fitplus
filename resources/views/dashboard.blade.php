<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-gradient-to-r from-teal-700 to-cyan-600 text-white px-8 py-4 flex justify-between items-center shadow-lg">
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-300">{{ auth()->user()->nama ?? 'User' }} • {{ now()->locale('id')->format('l, j F Y') }}</span>
                    <i class="fas fa-user-circle text-2xl"></i>
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-8">
        <!-- Statistik Hari Ini -->
        <section class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Statistik Hari Ini</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Card Umur -->
                <div class="bg-white rounded-lg border-b-4 border-teal-400 p-5 hover:shadow transition">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-gray-600 text-sm font-medium">Umur</h3>
                        <i class="fas fa-birthday-cake text-teal-400 text-lg"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">{{ $todayData?->umur ?? '-' }}</p>
                    <p class="text-xs text-gray-500 mt-1">tahun</p>
                </div>

                <!-- Card Berat Badan -->
                <div class="bg-white rounded-lg border-b-4 border-cyan-400 p-5 hover:shadow transition">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-gray-600 text-sm font-medium">Berat Badan</h3>
                        <i class="fas fa-weight text-cyan-400 text-lg"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">{{ $todayData?->berat_badan ?? '-' }}</p>
                    <p class="text-xs text-gray-500 mt-1">kg</p>
                </div>

                <!-- Card Tinggi Badan -->
                <div class="bg-white rounded-lg border-b-4 border-purple-400 p-5 hover:shadow transition">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-gray-600 text-sm font-medium">Tinggi Badan</h3>
                        <i class="fas fa-ruler-vertical text-purple-400 text-lg"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">{{ $todayData?->tinggi_badan ?? '-' }}</p>
                    <p class="text-xs text-gray-500 mt-1">cm</p>
                </div>

                <!-- Card Jam Tidur -->
                <div class="bg-white rounded-lg border-b-4 border-lime-400 p-5 hover:shadow transition">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-gray-600 text-sm font-medium">Jam Tidur</h3>
                        <i class="fas fa-moon text-lime-400 text-lg"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">{{ $todayData?->jam_tidur ?? '-' }}</p>
                    <p class="text-xs text-gray-500 mt-1">jam</p>
                </div>

                <!-- Card Olahraga -->
                <div class="bg-white rounded-lg border-b-4 border-green-400 p-5 hover:shadow transition">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-gray-600 text-sm font-medium">Olahraga</h3>
                        <i class="fas fa-heartbeat text-green-400 text-lg"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">{{ $todayData?->olahraga ?? '-' }}</p>
                    <p class="text-xs text-gray-500 mt-1">menit</p>
                </div>
            </div>
        </section>

        <!-- Data Kesehatan -->
        <section class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Data Kesehatan</h2>
                <a href="{{ route('health-data.form') }}" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:shadow-lg text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>

            <!-- Riwayat Data -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Umur</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Berat</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Tinggi</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Tidur</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Olahraga</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse(auth()->user()->aktivitas()->orderBy('tanggal', 'desc')->get() as $data)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <i class="fas fa-calendar text-gray-400 mr-2"></i>{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $data->umur }} tahun</td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <i class="fas fa-weight text-cyan-500 mr-2"></i>{{ $data->berat_badan }} kg
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <i class="fas fa-ruler-vertical text-purple-500 mr-2"></i>{{ $data->tinggi_badan }} cm
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <i class="fas fa-moon text-lime-500 mr-2"></i>{{ $data->jam_tidur }} jam
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <i class="fas fa-dumbbell text-green-500 mr-2"></i>{{ $data->olahraga }} menit
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <form action="{{ route('health-data.destroy', $data->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-3xl mb-3 opacity-50"></i>
                                    <p class="mt-2">Belum ada data kesehatan. <a href="{{ route('health-data.form') }}" class="text-teal-600 hover:text-teal-700 font-medium">Tambah data sekarang</a></p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Summary Cards -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <!-- Debug Info -->
            <!-- rataBerat: {{ $rataBerat }} | rataTidur: {{ $rataTidur }} | totalOlahraga: {{ $totalOlahraga }} | tidurData: {{ $tidurData->count() }} -->
            
            <!-- Rata-rata Berat -->
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl shadow p-6 text-white hover:shadow-lg transition">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Rata-rata Berat</h3>
                    <i class="fas fa-{{ $statusBerat['icon'] }} text-lg"></i>
                </div>
                <p class="text-3xl font-bold mt-3">{{ $rataBerat }} kg</p>
                <p class="text-xs opacity-75 mt-2">Dari {{ $aktivitas->count() }} data</p>
                <div class="mt-3 pt-3 border-t border-white border-opacity-30">
                    <span class="text-xs font-semibold inline-block px-2 py-1 bg-white bg-opacity-20 rounded">
                        {{ $statusBerat['status'] }}
                    </span>
                    <p class="text-xs opacity-75 mt-1">{{ $statusBerat['deskripsi'] }}</p>
                </div>
            </div>

            <!-- Rata-rata Tidur -->
            <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-xl shadow p-6 text-white hover:shadow-lg transition">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Rata-rata Tidur</h3>
                    <i class="fas fa-{{ $statusTidur['icon'] }} text-lg"></i>
                </div>
                <p class="text-3xl font-bold mt-3">{{ $rataTidur }} jam</p>
                <p class="text-xs opacity-75 mt-2">Dari {{ $tidurData->count() }} data</p>
                <div class="mt-3 pt-3 border-t border-white border-opacity-30">
                    <span class="text-xs font-semibold inline-block px-2 py-1 bg-white bg-opacity-20 rounded">
                        {{ $statusTidur['status'] }}
                    </span>
                    <p class="text-xs opacity-75 mt-1">{{ $statusTidur['deskripsi'] }}</p>
                </div>
            </div>

            <!-- Total Olahraga -->
            <div class="bg-gradient-to-r from-lime-500 to-lime-600 rounded-xl shadow p-6 text-white hover:shadow-lg transition">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Total Olahraga</h3>
                    <i class="fas fa-{{ $statusOlahraga['icon'] }} text-lg"></i>
                </div>
                <p class="text-3xl font-bold mt-3">{{ $totalOlahraga }} menit</p>
                <p class="text-xs opacity-75 mt-2">Dari {{ $aktivitas->count() }} data</p>
                <div class="mt-3 pt-3 border-t border-white border-opacity-30">
                    <span class="text-xs font-semibold inline-block px-2 py-1 bg-white bg-opacity-20 rounded">
                        {{ $statusOlahraga['status'] }}
                    </span>
                    <p class="text-xs opacity-75 mt-1">{{ $statusOlahraga['deskripsi'] }}</p>
                </div>
            </div>
        </section>

            </div>
        </div>
    </div>

    <script>
        // Auto-refresh dashboard setiap 5 detik untuk data hari ini yang selalu fresh
        setInterval(function() {
            // Reload halaman untuk mendapatkan data terbaru
            location.reload();
        }, 5000); // Refresh setiap 5 detik
    </script>
</body>
</html>