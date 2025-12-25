<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kesehatan - FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #16a34a;
            --primary-dark: #15803d;
            --secondary: #0d9488;
            --accent: #f59e0b;
        }
        
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #f0fdfa 100%);
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--primary) 0%, var(--secondary) 100%);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .sidebar-item {
            transition: all 0.3s ease;
            border-radius: 12px;
            margin-bottom: 0.5rem;
        }

        .sidebar-item:hover {
            background: rgba(255,255,255,0.15);
            transform: translateX(4px);
        }

        .sidebar-item.active {
            background: rgba(255,255,255,0.25);
            border-left: 4px solid white;
        }

        .topbar {
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border-left: 5px solid;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            opacity: 0.1;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .stat-card.primary {
            border-left-color: var(--primary);
        }

        .stat-card.primary::before {
            background: var(--primary);
        }

        .stat-card.secondary {
            border-left-color: var(--secondary);
        }

        .stat-card.secondary::before {
            background: var(--secondary);
        }

        .stat-card.accent {
            border-left-color: var(--accent);
        }

        .stat-card.accent::before {
            background: var(--accent);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
            color: #1f2937;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 0.5rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .badge.positive {
            background: #dcfce7;
            color: #166534;
        }

        .badge.negative {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge.neutral {
            background: #f3f4f6;
            color: #374151;
        }

        .alert-box {
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            gap: 1rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .alert-box.success {
            background: linear-gradient(135deg, #dcfce7 0%, #d1fae5 100%);
            border-color: rgba(34, 197, 94, 0.2);
        }

        .alert-box.warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-color: rgba(245, 158, 11, 0.2);
        }

        .alert-box.info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: rgba(59, 130, 246, 0.2);
        }

        .alert-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
            line-height: 1;
        }

        .alert-box.success .alert-icon {
            color: #15803d;
        }

        .alert-box.warning .alert-icon {
            color: #b45309;
        }

        .alert-box.info .alert-icon {
            color: #1e40af;
        }

        .alert-title {
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .alert-message {
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .chart-container {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .chart-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .chart-title i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .btn-modern {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .btn-outline {
            background: white;
            color: var(--primary);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: 2px solid var(--primary);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .filter-group {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
            background: white;
            color: #6b7280;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            border-color: var(--primary);
            background: var(--primary);
            color: white;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin: 2rem 0 1rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: var(--primary);
            font-size: 1.375rem;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.25rem;
        }

        @media (max-width: 768px) {
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .text-muted {
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .icon-lg {
            font-size: 2.5rem;
            line-height: 1;
        }
    </style>
</head>
<body>
    @if(!isset($user) || !$user)
        <div class="flex h-screen items-center justify-center bg-red-50">
            <div class="text-center p-8">
                <div class="text-6xl text-red-500 mb-4"><i class="fas fa-lock"></i></div>
                <h1 class="text-2xl font-bold text-red-800 mb-2">Akses Ditolak</h1>
                <p class="text-red-600 mb-6">Silakan login terlebih dahulu</p>
                <a href="{{ route('login.form') }}" class="inline-block px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Kembali ke Login
                </a>
            </div>
        </div>
    @else
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="sidebar w-64 text-white p-6 overflow-y-auto">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center font-bold text-lg">
                    <i class="fas fa-heartbeat text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">FitPlus</h2>
                    <p class="text-xs text-green-100">Kesehatan Terjaga</p>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center gap-3 px-4 py-3">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('profil') }}" class="sidebar-item flex items-center gap-3 px-4 py-3">
                    <i class="fas fa-user-circle"></i>
                    <span>Profil</span>
                </a>
                <a href="{{ route('makanan.harian') }}" class="sidebar-item flex items-center gap-3 px-4 py-3">
                    <i class="fas fa-utensils"></i>
                    <span>Pelacak Nutrisi</span>
                </a>
                <a href="{{ route('kalori.bmi') }}" class="sidebar-item flex items-center gap-3 px-4 py-3">
                    <i class="fas fa-weight"></i>
                    <span>Indeks Massa Tubuh</span>
                </a>
                <a href="{{ route('tidur.analisis') }}" class="sidebar-item flex items-center gap-3 px-4 py-3">
                    <i class="fas fa-moon"></i>
                    <span>Pelacak Tidur</span>
                </a>
                <a href="{{ route('tantangan.progres') }}" class="sidebar-item flex items-center gap-3 px-4 py-3">
                    <i class="fas fa-flag"></i>
                    <span>Tantangan Olahraga</span>
                </a>
                <a href="{{ route('laporan.kesehatan') }}" class="sidebar-item active flex items-center gap-3 px-4 py-3">
                    <i class="fas fa-chart-bar"></i>
                    <span class="font-semibold">Laporan Kesehatan</span>
                </a>
            </nav>

            <div class="mt-auto pt-6 border-t border-green-400 border-opacity-30">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-item w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-red-500 hover:bg-opacity-20">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <div class="topbar text-white px-8 py-4 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">Laporan Kesehatan</h1>
                    <p class="text-sm text-green-100 mt-1">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        {{ now()->locale('id')->format('l, j F Y') }}
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="font-semibold">{{ $user->nama ?? 'User' }}</p>
                        <p class="text-sm text-green-100">{{ $user->email ?? '' }}</p>
                    </div>
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-lg">
                        <i class="fas fa-user-circle"></i>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-7xl mx-auto">

                    <!-- Filter Periode -->
                    <div class="mb-8">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Pilih Periode</h3>
                        <form action="{{ route('laporan.kesehatan') }}" method="GET" class="flex gap-2">
                            <button type="submit" name="periode" value="7" class="filter-btn @if($periode == '7') active @endif">
                                <i class="fas fa-calendar-week mr-1"></i> 7 Hari
                            </button>
                            <button type="submit" name="periode" value="14" class="filter-btn @if($periode == '14') active @endif">
                                <i class="fas fa-calendar mr-1"></i> 2 Minggu
                            </button>
                            <button type="submit" name="periode" value="30" class="filter-btn @if($periode == '30') active @endif">
                                <i class="fas fa-calendar-alt mr-1"></i> 30 Hari
                            </button>
                        </form>
                    </div>

                    <!-- Rekomendasi -->
                    <div class="mb-8">
                        <div class="section-title">
                            <i class="fas fa-lightbulb"></i>
                            Rekomendasi untuk Anda
                        </div>
                        <div class="space-y-3">
                            @foreach($rekomendasi as $item)
                            <div class="alert-box {{ $item['type'] }}">
                                <div class="alert-icon">
                                    <i class="{{ $item['icon'] }}"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="alert-title">{{ $item['title'] }}</div>
                                    <div class="alert-message">{{ $item['message'] }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Statistik Harian -->
                    <div class="mb-8">
                        <div class="section-title">
                            <i class="fas fa-calendar-day"></i>
                            Ringkasan Hari Ini
                        </div>
                        <div class="grid-4">
                            <div class="stat-card primary">
                                <div class="stat-label">
                                    <i class="fas fa-weight mr-1"></i> Berat Badan
                                </div>
                                <div class="stat-value">{{ $stats['berat_hari'] ?? '-' }}</div>
                                <div class="stat-info">kg</div>
                                @if($stats['berat_perubahan'] != 0)
                                <div class="badge @if($stats['berat_perubahan'] > 0) negative @else positive @endif">
                                    <i class="fas fa-arrow-@if($stats['berat_perubahan'] > 0)up @else down @endif"></i>
                                    {{ abs($stats['berat_perubahan']) }}%
                                </div>
                                @endif
                            </div>

                            <div class="stat-card secondary">
                                <div class="stat-label">
                                    <i class="fas fa-moon mr-1"></i> Jam Tidur
                                </div>
                                <div class="stat-value">{{ $stats['tidur_hari'] ?? '-' }}</div>
                                <div class="stat-info">jam</div>
                                <div class="badge @if($stats['tidur_hari'] >= 7) positive @else neutral @endif">
                                    <i class="fas fa-info-circle"></i>
                                    @if($stats['tidur_hari'] >= 7) Optimal @else Kurang @endif
                                </div>
                            </div>

                            <div class="stat-card accent">
                                <div class="stat-label">
                                    <i class="fas fa-fire mr-1"></i> Olahraga
                                </div>
                                <div class="stat-value">{{ $stats['olahraga_hari'] }}</div>
                                <div class="stat-info">menit</div>
                                <div class="badge neutral">
                                    <i class="fas fa-check-circle"></i> Tercatat
                                </div>
                            </div>

                            <div class="stat-card primary">
                                <div class="stat-label">
                                    <i class="fas fa-apple-alt mr-1"></i> Kalori
                                </div>
                                <div class="stat-value">{{ $stats['kalori_hari'] }}</div>
                                <div class="stat-info">dari {{ $stats['kalori_target'] }} kkal</div>
                                <div class="badge @if($stats['kalori_persen'] <= 100) positive @else negative @endif">
                                    {{ round($stats['kalori_persen']) }}%
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Periode -->
                    <div class="mb-8">
                        <div class="section-title">
                            <i class="fas fa-chart-line"></i>
                            Statistik {{ $periode }} Hari Terakhir
                        </div>
                        <div class="grid-4">
                            <div class="stat-card primary">
                                <div class="stat-label">
                                    <i class="fas fa-weight mr-1"></i> Rata-rata Berat
                                </div>
                                <div class="stat-value">{{ $stats['berat_periode_avg'] }}</div>
                                <div class="stat-info">{{ $stats['aktivitas_periode_count'] }} data terdaftar</div>
                            </div>

                            <div class="stat-card secondary">
                                <div class="stat-label">
                                    <i class="fas fa-moon mr-1"></i> Rata-rata Tidur
                                </div>
                                <div class="stat-value">{{ $stats['tidur_periode_avg'] }}</div>
                                <div class="stat-info">{{ $stats['tidur_periode_count'] }} malam terdaftar</div>
                            </div>

                            <div class="stat-card accent">
                                <div class="stat-label">
                                    <i class="fas fa-fire mr-1"></i> Total Olahraga
                                </div>
                                <div class="stat-value">{{ $stats['olahraga_periode_total'] }}</div>
                                <div class="stat-info">menit / periode</div>
                            </div>

                            <div class="stat-card primary">
                                <div class="stat-label">
                                    <i class="fas fa-utensils mr-1"></i> Total Kalori
                                </div>
                                <div class="stat-value">{{ $stats['kalori_periode_total'] }}</div>
                                <div class="stat-info">{{ $stats['makanan_periode_count'] }} pencatatan</div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Berat Badan -->
                    <div class="chart-container" id="chartBeratContainer" style="display:none;">
                        <div class="chart-title">
                            <i class="fas fa-chart-line"></i>
                            Tren Berat Badan {{ $periode }} Hari
                        </div>
                        <canvas id="beratChart"></canvas>
                    </div>

                    <!-- Chart Tidur -->
                    <div class="chart-container" id="chartTidurContainer" style="display:none;">
                        <div class="chart-title">
                            <i class="fas fa-moon"></i>
                            Tren Jam Tidur {{ $periode }} Hari
                        </div>
                        <canvas id="tidurChart"></canvas>
                    </div>

                    <!-- Chart Olahraga -->
                    <div class="chart-container" id="chartOlahragaContainer" style="display:none;">
                        <div class="chart-title">
                            <i class="fas fa-fire"></i>
                            Tren Olahraga {{ $periode }} Hari
                        </div>
                        <canvas id="olahragaChart"></canvas>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 mt-8 mb-8">
                        <a href="{{ route('dashboard') }}" class="btn-outline">
                            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                        </a>
                        <button onclick="window.print()" class="btn-outline">
                            <i class="fas fa-print"></i> Cetak Laporan
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Ambil data dari controller
        const chartLabels = {!! $chartData['labels'] !!};
        const beratData = {!! $chartData['berat'] !!};
        const tidurData = {!! $chartData['tidur'] !!};
        const olahragaData = {!! $chartData['olahraga'] !!};

        const primaryColor = '#16a34a';
        const secondaryColor = '#0d9488';
        const accentColor = '#f59e0b';
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        font: { size: 12, weight: 600 },
                        color: '#6b7280',
                        padding: 15,
                        usePointStyle: true
                    }
                },
                filler: {
                    propagate: true
                }
            },
            scales: {
                y: {
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 11 },
                        color: '#9ca3af'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 11 },
                        color: '#9ca3af'
                    }
                }
            }
        };

        // Chart Berat Badan
        if (beratData && beratData.length > 0) {
            document.getElementById('chartBeratContainer').style.display = 'block';
            const ctx1 = document.getElementById('beratChart').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Berat Badan (kg)',
                        data: beratData,
                        borderColor: primaryColor,
                        backgroundColor: primaryColor + '15',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: primaryColor,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7
                    }]
                },
                options: chartOptions
            });
        }

        // Chart Tidur
        if (tidurData && tidurData.length > 0) {
            document.getElementById('chartTidurContainer').style.display = 'block';
            const ctx2 = document.getElementById('tidurChart').getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Jam Tidur',
                        data: tidurData,
                        borderColor: secondaryColor,
                        backgroundColor: secondaryColor + '15',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: secondaryColor,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7
                    }]
                },
                options: chartOptions
            });
        }

        // Chart Olahraga
        if (olahragaData && olahragaData.length > 0) {
            document.getElementById('chartOlahragaContainer').style.display = 'block';
            const ctx3 = document.getElementById('olahragaChart').getContext('2d');
            new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Durasi Olahraga (menit)',
                        data: olahragaData,
                        backgroundColor: accentColor,
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    ...chartOptions,
                    plugins: {
                        ...chartOptions.plugins,
                        legend: {
                            display: true,
                            labels: {
                                font: { size: 12, weight: 600 },
                                color: '#6b7280',
                                padding: 15
                            }
                        }
                    }
                }
            });
        }
    </script>
    @endif
</body>
</html>
