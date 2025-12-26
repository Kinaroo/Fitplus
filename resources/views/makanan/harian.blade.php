<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelacak Nutrisi - FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-teal-600 to-cyan-500 text-white p-6 shadow-xl overflow-y-auto">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-teal-300 to-cyan-300 rounded-lg flex items-center justify-center font-bold text-teal-600 text-lg">
                    ❤️
                </div>
                <div>
                    <h2 class="text-xl font-bold">FitPlus</h2>
                    <p class="text-xs text-blue-100">{{ auth()->user()->nama ?? 'User' }}</p>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-chart-line text-lg"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-user-circle text-lg"></i>
                    <span>Profil</span>
                </a>
                <a href="{{ route('makanan.harian') }}" class="flex items-center gap-3 bg-white bg-opacity-20 px-4 py-3 rounded-lg hover:bg-opacity-30 transition">
                    <i class="fas fa-utensils text-lg text-red-300"></i>
                    <span font-medium>Pelacak Nutrisi</span>
                </a>
                <a href="{{ route('kalori.bmi') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-weight text-lg text-orange-300"></i>
                    <span>Indeks Massa Tubuh</span>
                </a>
                <a href="{{ route('tidur.analisis') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-moon text-lg text-indigo-300"></i>
                    <span>Pelacak Tidur</span>
                </a>
                <a href="{{ route('tantangan.progres') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-flag text-lg text-purple-300"></i>
                    <span>Tantangan Olahraga</span>
                </a>
                <a href="{{ route('laporan.kesehatan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-chart-bar text-lg text-green-300"></i>
                    <span>Laporan Kesehatan</span>
                </a>
            </nav>

            <div class="mt-auto pt-6 border-t border-blue-400">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-500 hover:bg-opacity-20 transition text-red-200 font-medium">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-gradient-to-r from-teal-700 to-cyan-600 text-white px-8 py-4 flex justify-between items-center shadow-lg">
                <h1 class="text-2xl font-bold">Pelacak Nutrisi</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-300">{{ auth()->user()->nama ?? 'User' }} • {{ now()->locale('id')->format('l, j F Y') }}</span>
                    <i class="fas fa-user-circle text-2xl"></i>
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <!-- Kalori Harian -->
                <section class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Kalori Harian Hari Ini</h2>
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <?php
                            $totalKalori = $makananHariIni->sum('total_kalori');
                            $estimasiKalori = 2000; // Default estimation
                            $persen = $estimasiKalori > 0 ? min(($totalKalori / $estimasiKalori) * 100, 100) : 0;
                        ?>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <!-- Kalori Konsumsi -->
                            <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl p-6 border-l-4 border-orange-500">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-sm font-semibold text-gray-700">Kalori Konsumsi</h3>
                                    <i class="fas fa-fire text-orange-500 text-2xl"></i>
                                </div>
                                <p class="text-3xl font-bold text-orange-600">{{ $totalKalori }}</p>
                                <p class="text-xs text-gray-600 mt-2">dari {{ $makananHariIni->count() }} makanan</p>
                            </div>

                            <!-- Target Kalori -->
                            <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl p-6 border-l-4 border-teal-500">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-sm font-semibold text-gray-700">Target Kalori</h3>
                                    <i class="fas fa-bullseye text-teal-500 text-2xl"></i>
                                </div>
                                <p class="text-3xl font-bold text-teal-600">{{ $estimasiKalori }}</p>
                                <p class="text-xs text-gray-600 mt-2">per hari</p>
                            </div>

                            <!-- Sisa Kalori -->
                            <div class="bg-gradient-to-br from-green-50 to-lime-50 rounded-xl p-6 border-l-4 border-green-500">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-sm font-semibold text-gray-700">Sisa Kalori</h3>
                                    <i class="fas fa-leaf text-green-500 text-2xl"></i>
                                </div>
                                <p class="text-3xl font-bold text-green-600">{{ max(0, $estimasiKalori - $totalKalori) }}</p>
                                <p class="text-xs text-gray-600 mt-2">tersisa</p>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-gray-700">Progress Kalori</span>
                                <span class="text-sm font-bold text-gray-600">{{ round($persen) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                                <div class="bg-gradient-to-r from-orange-400 to-red-500 h-full rounded-full transition-all duration-300" style="width: {{ min($persen, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Makanan Hari Ini -->
                <section class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Makanan Hari Ini</h2>
                        <a href="{{ route('makanan.form') }}" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:shadow-lg text-white px-6 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition">
                            <i class="fas fa-plus"></i> Tambah Makanan
                        </a>
                    </div>

                    @if($makananHariIni->count() > 0)
                    <div class="space-y-3">
                        @foreach($makananHariIni as $item)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-5 border-l-4 border-teal-400">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">{{ $item->makanan->nama_makanan ?? 'N/A' }}</h3>
                                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                                        <span><i class="fas fa-clone text-teal-500 mr-1"></i>{{ $item->porsi }} porsi</span>
                                        <span><i class="fas fa-fire text-orange-500 mr-1"></i>{{ $item->total_kalori }} kkal</span>
                                        <span><i class="fas fa-clock text-gray-400 mr-1"></i>{{ \Carbon\Carbon::parse($item->tanggal)->format('H:i') }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('makanan.delete', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus makanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition">
                                            <i class="fas fa-trash text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 mb-4">Belum ada makanan yang dicatat hari ini</p>
                        <a href="{{ route('makanan.form') }}" class="bg-gradient-to-r from-teal-500 to-cyan-600 text-white px-6 py-2 rounded-lg font-medium hover:shadow-lg transition inline-block">
                            <i class="fas fa-plus mr-2"></i>Mulai Catat
                        </a>
                    </div>
                    @endif
                </section>

                <!-- Analisis Nutrisi -->
                <section class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Analisis Nutrisi</h2>
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <?php
                            // Target nilai
                            $targetProtein = 50;
                            $targetKarbo = 250;
                            $targetLemak = 65;
                            
                            // Kalkulasi total dari data
                            $totalProtein = $makananHariIni->sum(function($item) {
                                return ($item->makanan->protein ?? 0) * $item->porsi;
                            });
                            $totalKarbo = $makananHariIni->sum(function($item) {
                                return ($item->makanan->karbohidrat ?? 0) * $item->porsi;
                            });
                            $totalLemak = $makananHariIni->sum(function($item) {
                                return ($item->makanan->lemak ?? 0) * $item->porsi;
                            });
                            
                            // Hitung persentase
                            $persenProtein = $targetProtein > 0 ? min(($totalProtein / $targetProtein) * 100, 100) : 0;
                            $persenKarbo = $targetKarbo > 0 ? min(($totalKarbo / $targetKarbo) * 100, 100) : 0;
                            $persenLemak = $targetLemak > 0 ? min(($totalLemak / $targetLemak) * 100, 100) : 0;
                            
                            // Status
                            $statusProtein = $totalProtein >= $targetProtein ? '✓ Terpenuhi' : '⚠ Kurang';
                            $statusKarbo = $totalKarbo >= $targetKarbo ? '✓ Terpenuhi' : '⚠ Kurang';
                            $statusLemak = $totalLemak >= $targetLemak ? '✓ Terpenuhi' : '⚠ Berlebih';
                        ?>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Protein -->
                            <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-lg p-5 border-l-4 border-red-500">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-dumbbell text-red-500 text-2xl"></i>
                                        <h3 class="font-semibold text-gray-700">Protein</h3>
                                    </div>
                                    <span class="text-xs font-bold bg-red-100 text-red-700 px-2 py-1 rounded">{{ round($persenProtein) }}%</span>
                                </div>
                                <p class="text-2xl font-bold text-red-600">{{ round($totalProtein, 1) }}g</p>
                                <p class="text-xs text-gray-600 mt-1">Target: {{ $targetProtein }}g</p>
                                <div class="mt-3 bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-red-400 to-red-600 h-full transition-all duration-300" style="width: {{ min($persenProtein, 100) }}%"></div>
                                </div>
                                <p class="text-xs mt-2 font-medium {{ $totalProtein >= $targetProtein ? 'text-green-600' : 'text-orange-600' }}">
                                    {{ $totalProtein >= $targetProtein ? '✓ Terpenuhi' : '⚠ Kurang ' . round($targetProtein - $totalProtein, 1) . 'g' }}
                                </p>
                            </div>

                            <!-- Karbohidrat -->
                            <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-lg p-5 border-l-4 border-yellow-500">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-bread-slice text-yellow-600 text-2xl"></i>
                                        <h3 class="font-semibold text-gray-700">Karbohidrat</h3>
                                    </div>
                                    <span class="text-xs font-bold bg-yellow-100 text-yellow-700 px-2 py-1 rounded">{{ round($persenKarbo) }}%</span>
                                </div>
                                <p class="text-2xl font-bold text-yellow-600">{{ round($totalKarbo, 1) }}g</p>
                                <p class="text-xs text-gray-600 mt-1">Target: {{ $targetKarbo }}g</p>
                                <div class="mt-3 bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 h-full transition-all duration-300" style="width: {{ min($persenKarbo, 100) }}%"></div>
                                </div>
                                <p class="text-xs mt-2 font-medium {{ $totalKarbo >= $targetKarbo ? 'text-green-600' : 'text-orange-600' }}">
                                    {{ $totalKarbo >= $targetKarbo ? '✓ Terpenuhi' : '⚠ Kurang ' . round($targetKarbo - $totalKarbo, 1) . 'g' }}
                                </p>
                            </div>

                            <!-- Lemak -->
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-lg p-5 border-l-4 border-purple-500">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-droplet text-purple-500 text-2xl"></i>
                                        <h3 class="font-semibold text-gray-700">Lemak</h3>
                                    </div>
                                    <span class="text-xs font-bold bg-purple-100 text-purple-700 px-2 py-1 rounded">{{ round($persenLemak) }}%</span>
                                </div>
                                <p class="text-2xl font-bold text-purple-600">{{ round($totalLemak, 1) }}g</p>
                                <p class="text-xs text-gray-600 mt-1">Target: {{ $targetLemak }}g</p>
                                <div class="mt-3 bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-purple-400 to-purple-600 h-full transition-all duration-300" style="width: {{ min($persenLemak, 100) }}%"></div>
                                </div>
                                <p class="text-xs mt-2 font-medium {{ $totalLemak <= $targetLemak ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $totalLemak <= $targetLemak ? '✓ Normal' : '⚠ Berlebih ' . round($totalLemak - $targetLemak, 1) . 'g' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        function deleteMakanan(id) {
            if (confirm('Yakin ingin menghapus makanan ini?')) {
                // Implement delete via AJAX or form submission
                console.log('Delete makanan:', id);
            }
        }
    </script>
</body>
</html>
