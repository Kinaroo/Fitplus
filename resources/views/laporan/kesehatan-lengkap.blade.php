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
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('makanan.harian') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-utensils"></i>
                    <span>Pelacak Nutrisi</span>
                </a>
                <a href="{{ route('kalori.bmi') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-weight"></i>
                    <span>Indeks Massa Tubuh</span>
                </a>
                <a href="{{ route('tidur.analisis') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-moon"></i>
                    <span>Pelacak Tidur</span>
                </a>
                <a href="{{ route('tantangan.progres') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-flag"></i>
                    <span>Tantangan Olahraga</span>
                </a>
                <a href="{{ route('laporan.kesehatan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white bg-opacity-20 transition">
                    <i class="fas fa-chart-bar"></i>
                    <span class="font-semibold">Laporan Kesehatan</span>
                </a>
            </nav>

            <div class="mt-auto pt-6 border-t border-green-400 border-opacity-30">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-500 hover:bg-opacity-20 text-left transition">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <div class="bg-gradient-to-r from-green-700 to-teal-600 text-white px-8 py-4 shadow-md">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">Laporan Kesehatan {{ $user->nama ?? 'Pengguna' }}</h1>
                        <p class="text-sm text-green-100 mt-1">
                            Periode: {{ $periode }} hari
                        </p>
                    </div>
                    <button onclick="window.print()" class="flex items-center gap-2 px-4 py-2 bg-white text-green-700 rounded-lg hover:bg-green-50 font-semibold transition">
                        <i class="fas fa-download"></i>
                        Download PDF
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-6xl mx-auto space-y-8">
                    
                    <!-- Stat Cards -->
                    <div class="grid grid-cols-4 gap-4">
                        <div class="bg-white rounded-lg p-6 shadow">
                            <p class="text-sm text-gray-600 mb-2">Berat Badan Rata-rata</p>
                            <p class="text-3xl font-bold text-blue-600">
                                {{ $stats['berat_periode_avg'] != '-' ? $stats['berat_periode_avg'] . ' kg' : '-' }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $stats['berat_perubahan'] > 0 ? '⬆ ' . $stats['berat_perubahan'] . ' kg' : (number_format($stats['berat_perubahan'], 1) == 0 ? 'Stabil' : '⬇ ' . abs($stats['berat_perubahan']) . ' kg') }}
                            </p>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow">
                            <p class="text-sm text-gray-600 mb-2">Tidur Rata-rata</p>
                            <p class="text-3xl font-bold text-purple-600">
                                {{ $stats['tidur_periode_avg'] != '-' ? $stats['tidur_periode_avg'] . ' jam' : '-' }}
                            </p>
                            <p class="text-xs text-green-600 mt-1">✓ Baik</p>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow">
                            <p class="text-sm text-gray-600 mb-2">Olahraga Total</p>
                            <p class="text-3xl font-bold text-orange-600">
                                {{ $stats['olahraga_periode_total'] ?? 0 }} menit
                            </p>
                            <p class="text-xs text-green-600 mt-1">
                                {{ $stats['aktivitas_periode_count'] ?? 0 }} hari
                            </p>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow">
                            <p class="text-sm text-gray-600 mb-2">Kalori Total</p>
                            <p class="text-3xl font-bold text-red-600">
                                {{ $stats['kalori_periode_total'] ?? 0 }} kcal
                            </p>
                            <p class="text-xs text-green-600 mt-1">
                                Target: {{ $stats['kalori_target'] ?? 2000 }} kcal
                            </p>
                        </div>
                    </div>

                    <!-- IMT Section -->
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-white rounded-lg p-6 shadow">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">Indeks Massa Tubuh (IMT)</h2>
                            <div class="text-center mb-6">
                                @php
                                    $berat_value = $stats['berat_hari'];
                                    if ($berat_value != '-') {
                                        $berat_value = is_numeric($berat_value) ? (float)$berat_value : (float)str_replace(' kg', '', $berat_value);
                                    }
                                    $berat = $berat_value != '-' ? $berat_value : null;
                                    $tinggi = $user->tinggi ?? null;
                                    $imt = $berat && $tinggi ? round($berat / (($tinggi/100)**2), 1) : null;
                                    $kategori = '';
                                    if ($imt) {
                                        if ($imt < 18.5) $kategori = 'Kurang Berat';
                                        elseif ($imt <= 24.9) $kategori = 'Normal';
                                        elseif ($imt <= 29.9) $kategori = 'Kelebihan Berat';
                                        else $kategori = 'Obesitas';
                                    }
                                @endphp
                                <p class="text-5xl font-bold text-blue-600">{{ $imt ?? '-' }}</p>
                                <p class="text-gray-600 mt-2">{{ $kategori ?? 'Tidak ada data' }}</p>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs text-gray-600 mb-2">
                                    <span>< 18.5</span>
                                    <span>18.5-24.9</span>
                                    <span>25-29.9</span>
                                    <span>> 30</span>
                                </div>
                                <div class="h-2 bg-gradient-to-r from-blue-400 via-green-400 to-red-400 rounded-full"></div>
                            </div>
                            <div class="mt-6 space-y-2 text-sm">
                                <p class="text-gray-700"><strong>Tinggi Badan:</strong> {{ $user->tinggi ?? '-' }} cm</p>
                                <p class="text-gray-700"><strong>Berat Badan Saat Ini:</strong> {{ $stats['berat_hari'] ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Ringkasan Data -->
                        <div class="bg-white rounded-lg p-6 shadow">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Periode</h2>
                            <div class="space-y-3">
                                <div class="flex justify-between p-3 bg-gray-50 rounded">
                                    <span class="text-gray-700">Data Aktivitas Tercatat</span>
                                    <span class="font-bold text-teal-600">{{ $stats['aktivitas_periode_count'] ?? 0 }} hari</span>
                                </div>
                                <div class="flex justify-between p-3 bg-gray-50 rounded">
                                    <span class="text-gray-700">Data Tidur Tercatat</span>
                                    <span class="font-bold text-purple-600">{{ $stats['tidur_periode_count'] ?? 0 }} hari</span>
                                </div>
                                <div class="flex justify-between p-3 bg-gray-50 rounded">
                                    <span class="text-gray-700">Data Makanan Tercatat</span>
                                    <span class="font-bold text-orange-600">{{ $stats['makanan_periode_count'] ?? 0 }} item</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nutrisi & Diet -->
                    <div class="bg-white rounded-lg p-6 shadow">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Laporan Nutrisi & Diet Harian</h2>
                        <div class="grid grid-cols-3 gap-6">
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-2">Kalori Hari Ini</p>
                                <p class="text-3xl font-bold text-red-600">{{ $stats['kalori_hari'] ?? 0 }} kcal</p>
                                <p class="text-xs text-green-600 mt-1">Target: {{ $stats['kalori_target'] ?? 2000 }}kcal</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-2">Total Makanan Periode</p>
                                <p class="text-3xl font-bold text-yellow-600">{{ $stats['makanan_periode_count'] ?? 0 }}</p>
                                <p class="text-xs text-gray-600 mt-1">item dicatat</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-2">Persentase Target</p>
                                <p class="text-3xl font-bold text-orange-600">{{ $stats['kalori_persen'] ?? 0 }}%</p>
                                <p class="text-xs text-gray-600 mt-1">dari target harian</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rekomendasi Diet -->
                    @if (!empty($rekomendasi))
                    <div class="space-y-4">
                        <h2 class="text-lg font-bold text-gray-800">Rekomendasi & Saran</h2>
                        @foreach ($rekomendasi as $saran)
                            @if ($saran['color'] == 'blue')
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                    <p class="font-bold text-blue-900 mb-1">
                                        <i class="{{ $saran['icon'] }} mr-2"></i>{{ $saran['title'] }}
                                    </p>
                                    <p class="text-blue-800 text-sm">{{ $saran['message'] }}</p>
                                </div>
                            @elseif ($saran['color'] == 'yellow')
                                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                                    <p class="font-bold text-yellow-900 mb-1">
                                        <i class="{{ $saran['icon'] }} mr-2"></i>{{ $saran['title'] }}
                                    </p>
                                    <p class="text-yellow-800 text-sm">{{ $saran['message'] }}</p>
                                </div>
                            @elseif ($saran['color'] == 'orange')
                                <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded">
                                    <p class="font-bold text-orange-900 mb-1">
                                        <i class="{{ $saran['icon'] }} mr-2"></i>{{ $saran['title'] }}
                                    </p>
                                    <p class="text-orange-800 text-sm">{{ $saran['message'] }}</p>
                                </div>
                            @elseif ($saran['color'] == 'red')
                                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                                    <p class="font-bold text-red-900 mb-1">
                                        <i class="{{ $saran['icon'] }} mr-2"></i>{{ $saran['title'] }}
                                    </p>
                                    <p class="text-red-800 text-sm">{{ $saran['message'] }}</p>
                                </div>
                            @else
                                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                                    <p class="font-bold text-green-900 mb-1">
                                        <i class="{{ $saran['icon'] }} mr-2"></i>{{ $saran['title'] }}
                                    </p>
                                    <p class="text-green-800 text-sm">{{ $saran['message'] }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @endif

                    <!-- Rekomendasi & Target -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-bold text-gray-800">Target Kesehatan</h2>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <p class="font-bold text-blue-900 mb-1">
                                <i class="fas fa-heartbeat mr-2"></i>Target Kalori
                            </p>
                            <p class="text-blue-800 text-sm">Target kalori harian Anda adalah {{ $stats['kalori_target'] ?? 2000 }} kcal. Saat ini konsumsi Anda {{ $stats['kalori_persen'] ?? 0 }}% dari target.</p>
                        </div>

                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                            <p class="font-bold text-yellow-900 mb-1">
                                <i class="fas fa-bed mr-2"></i>Target Tidur
                            </p>
                            <p class="text-yellow-800 text-sm">Target tidur optimal adalah 7-8 jam per malam. Rata-rata tidur Anda saat ini {{ $stats['tidur_periode_avg'] ?? '-' }} jam. {{ $stats['tidur_periode_avg'] != '-' && $stats['tidur_periode_avg'] >= 7 ? '✓ Sudah mencapai target!' : 'Tingkatkan durasi tidur Anda.' }}</p>
                        </div>

                        <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded">
                            <p class="font-bold text-purple-900 mb-1">
                                <i class="fas fa-running mr-2"></i>Target Olahraga
                            </p>
                            <p class="text-purple-800 text-sm">Aktivitas fisik minimal 150 menit per minggu. Total olahraga Anda periode ini: {{ $stats['olahraga_periode_total'] ?? 0 }} menit. {{ $stats['olahraga_periode_total'] >= 150 ? '✓ Sudah memenuhi target!' : 'Tingkatkan aktivitas fisik Anda.' }}</p>
                        </div>

                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                            <p class="font-bold text-green-900 mb-1">
                                <i class="fas fa-apple-alt mr-2"></i>Target Berat Badan
                            </p>
                            <p class="text-green-800 text-sm">Berat badan saat ini: {{ $stats['berat_hari'] ?? '-' }}. Rata-rata periode: {{ $stats['berat_periode_avg'] ?? '-' }} kg. Tetap konsisten dengan pola makan sehat dan olahraga teratur.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style media="print">
        @page {
            size: A4;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
        }
        .no-print {
            display: none !important;
        }
    </style>
</body>
</html>
