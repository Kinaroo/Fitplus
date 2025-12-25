<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kesehatan - FitPlus</title>
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
                <a href="{{ route('makanan.harian') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-utensils text-lg text-red-300"></i>
                    <span>Pelacak Nutrisi</span>
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
                <a href="{{ route('laporan.kesehatan') }}" class="flex items-center gap-3 bg-white bg-opacity-20 px-4 py-3 rounded-lg hover:bg-opacity-30 transition">
                    <i class="fas fa-chart-bar text-lg text-green-300"></i>
                    <span class="font-medium">Laporan Kesehatan</span>
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
                <h1 class="text-2xl font-bold">Laporan Kesehatan Berkala</h1>
                <div class="flex items-center gap-4">
                    <a href="{{ route('laporan.kesehatan.pdf') }}" class="bg-cyan-400 hover:bg-cyan-500 text-gray-800 font-bold py-2 px-4 rounded-lg transition flex items-center gap-2">
                        <i class="fas fa-download"></i>
                        Download PDF
                    </a>
                    <span class="text-sm text-gray-300">{{ auth()->user()->nama ?? 'User' }} • {{ now()->locale('id')->format('d F Y') }}</span>
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-6xl mx-auto space-y-6">

                    <!-- Header Info -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-cyan-500">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Laporan Kesehatan Berkala</h2>
                        <div class="grid grid-cols-4 gap-4 text-center">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-600 text-sm font-semibold">Berat Badan Rata-rata</p>
                                <p class="text-2xl font-bold text-teal-600">{{ $stats['berat_periode_avg'] ?? '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $stats['berat_perubahan'] ?? '0' }} kg</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-600 text-sm font-semibold">Tidur Rata-rata</p>
                                <p class="text-2xl font-bold text-purple-600">{{ $stats['tidur_periode_avg'] ?? '-' }}</p>
                                <p class="text-xs text-gray-500">jam/hari</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-600 text-sm font-semibold">Olahraga Rata-rata</p>
                                <p class="text-2xl font-bold text-green-600">{{ $stats['olahraga_periode_avg'] ?? '-' }}</p>
                                <p class="text-xs text-gray-500">menit/hari</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-600 text-sm font-semibold">Kalori Rata-rata</p>
                                <p class="text-2xl font-bold text-orange-600">{{ $stats['kalori_periode_avg'] ?? '-' }}</p>
                                <p class="text-xs text-gray-500">kkal/hari</p>
                            </div>
                        </div>
                    </div>

                    <!-- IMT Section -->
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Indeks Massa Tubuh (IMT)</h2>
                        <div class="grid grid-cols-2 gap-8">
                            <!-- IMT Value -->
                            <div class="flex flex-col items-center justify-center">
                                @php
                                    $berat_value = $stats['berat_hari'];
                                    if ($berat_value != '-') {
                                        $berat_value = is_numeric($berat_value) ? (float)$berat_value : (float)str_replace(' kg', '', $berat_value);
                                    }
                                    $berat = $berat_value != '-' ? $berat_value : null;
                                    $tinggi = $user->tinggi ?? null;
                                    $imt = $berat && $tinggi ? round($berat / (($tinggi/100)**2), 1) : null;
                                    $kategori = '-';
                                    $warna = 'text-gray-600';
                                    $bgWarna = 'bg-gray-50';
                                    
                                    if ($imt) {
                                        if ($imt < 18.5) {
                                            $kategori = 'Kurang Berat';
                                            $warna = 'text-blue-600';
                                            $bgWarna = 'bg-blue-50';
                                        } elseif ($imt <= 24.9) {
                                            $kategori = 'Normal';
                                            $warna = 'text-green-600';
                                            $bgWarna = 'bg-green-50';
                                        } elseif ($imt <= 29.9) {
                                            $kategori = 'Kelebihan Berat';
                                            $warna = 'text-yellow-600';
                                            $bgWarna = 'bg-yellow-50';
                                        } else {
                                            $kategori = 'Obesitas';
                                            $warna = 'text-red-600';
                                            $bgWarna = 'bg-red-50';
                                        }
                                    }
                                @endphp
                                <div class="text-center {{ $bgWarna }} rounded-lg p-8 w-full">
                                    <p class="text-gray-600 text-sm font-semibold mb-2">INDEKS MASSA TUBUH</p>
                                    <p class="text-6xl font-bold {{ $warna }} mb-2">{{ $imt ?? '-' }}</p>
                                    <p class="text-lg font-semibold text-gray-700">{{ $kategori }}</p>
                                </div>
                            </div>

                            <!-- IMT Details -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-600 text-sm">Tinggi Badan</p>
                                    <p class="text-2xl font-bold text-gray-800">{{ $user->tinggi ?? '-' }} cm</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-600 text-sm">Berat Badan Saat Ini</p>
                                    <p class="text-2xl font-bold text-gray-800">{{ $stats['berat_hari'] ?? '-' }} kg</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-600 text-sm">Berat Badan Ideal</p>
                                    <p class="text-2xl font-bold text-gray-800">{{ $user->tinggi ? round(22.5 * (($user->tinggi/100)**2), 1) : '-' }} kg</p>
                                </div>
                            </div>
                        </div>

                        <!-- IMT Scale -->
                        <div class="mt-8 pt-8 border-t">
                            <p class="text-sm font-bold text-gray-700 mb-4">Skala Kategori IMT</p>
                            <div class="flex gap-2 h-8 rounded-lg overflow-hidden shadow-md mb-4">
                                <div class="flex-1 bg-blue-500 flex items-center justify-center text-white text-xs font-bold">< 18.5</div>
                                <div class="flex-1 bg-green-500 flex items-center justify-center text-white text-xs font-bold">18.5-24.9</div>
                                <div class="flex-1 bg-yellow-500 flex items-center justify-center text-white text-xs font-bold">25-29.9</div>
                                <div class="flex-1 bg-red-500 flex items-center justify-center text-white text-xs font-bold">> 30</div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Makanan & Kalori -->
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <i class="fas fa-utensils text-orange-500"></i>
                            Detail Pelacak Nutrisi
                        </h2>
                        
                        <!-- Kalori Overview -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-6 border-l-4 border-orange-500">
                                <p class="text-gray-600 text-sm font-semibold">Kalori Hari Ini</p>
                                <p class="text-3xl font-bold text-orange-600">{{ $stats['kalori_hari'] ?? 0 }}</p>
                                <p class="text-xs text-gray-500">kkal</p>
                            </div>
                            
                            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-6 border-l-4 border-yellow-500">
                                <p class="text-gray-600 text-sm font-semibold">Kalori Target</p>
                                <p class="text-3xl font-bold text-yellow-600">{{ $stats['kalori_target'] ?? 2000 }}</p>
                                <p class="text-xs text-gray-500">kkal/hari</p>
                            </div>
                            
                            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-6 border-l-4 border-red-500">
                                <p class="text-gray-600 text-sm font-semibold">Persentase Target</p>
                                <p class="text-3xl font-bold text-red-600">{{ $stats['kalori_persen'] ?? 0 }}%</p>
                                <p class="text-xs text-gray-500">dari target harian</p>
                            </div>

                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border-l-4 border-green-500">
                                <p class="text-gray-600 text-sm font-semibold">Total Kalori Periode</p>
                                <p class="text-3xl font-bold text-green-600">{{ number_format($stats['kalori_periode_total'] ?? 0) }}</p>
                                <p class="text-xs text-gray-500">{{ $stats['makanan_periode_count'] ?? 0 }} data makanan</p>
                            </div>
                        </div>

                        <!-- Riwayat Makanan -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-history text-orange-600"></i>
                                Riwayat Makanan 5 Hari Terakhir
                            </h3>
                            @if($makananPeriode && $makananPeriode->count() > 0)
                                <div class="space-y-3">
                                    @foreach($makananPeriode->reverse()->take(15) as $makanan)
                                    <div class="bg-white rounded-lg p-4 flex justify-between items-center border-l-4 border-orange-400">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $makanan->makanan?->nama_makanan ?? 'Makanan' }}</p>
                                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($makanan->tanggal)->format('d M Y') }} • {{ $makanan->porsi ?? 1 }} porsi</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-orange-600">{{ number_format($makanan->total_kalori ?? 0) }} kkal</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-4">Belum ada data makanan. Mulai catat makanan Anda di <a href="{{ route('makanan.harian') }}" class="text-orange-600 font-bold hover:underline">Pelacak Nutrisi</a></p>
                            @endif
                        </div>
                    </div>

                    <!-- Laporan Nutrisi -->
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Laporan Nutrisi & Diet Harian</h2>
                        <div class="grid grid-cols-3 gap-6">
                            <div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500">
                                <p class="text-gray-600 text-sm font-semibold">Protein Rata-rata</p>
                                <p class="text-3xl font-bold text-blue-600">{{ is_numeric($stats['protein_avg'] ?? null) && $stats['protein_avg'] != 0 ? number_format($stats['protein_avg'], 1) : 'N/A' }}</p>
                                <p class="text-xs text-gray-500 mt-2">Target: 80-100g</p>
                                @if(is_numeric($stats['protein_avg'] ?? null) && $stats['protein_avg'] != 0)
                                <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, (($stats['protein_avg'] ?? 0) / 100) * 100) }}%"></div>
                                </div>
                                @else
                                <p class="text-xs text-gray-400 mt-3">Belum ada data nutrisi</p>
                                @endif
                            </div>
                            <div class="bg-green-50 rounded-lg p-6 border-l-4 border-green-500">
                                <p class="text-gray-600 text-sm font-semibold">Karbohidrat Rata-rata</p>
                                <p class="text-3xl font-bold text-green-600">{{ is_numeric($stats['karbo_avg'] ?? null) && $stats['karbo_avg'] != 0 ? number_format($stats['karbo_avg'], 1) : 'N/A' }}</p>
                                <p class="text-xs text-gray-500 mt-2">Target: 200-300g</p>
                                @if(is_numeric($stats['karbo_avg'] ?? null) && $stats['karbo_avg'] != 0)
                                <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ min(100, (($stats['karbo_avg'] ?? 0) / 300) * 100) }}%"></div>
                                </div>
                                @else
                                <p class="text-xs text-gray-400 mt-3">Belum ada data nutrisi</p>
                                @endif
                            </div>
                            <div class="bg-orange-50 rounded-lg p-6 border-l-4 border-orange-500">
                                <p class="text-gray-600 text-sm font-semibold">Lemak Rata-rata</p>
                                <p class="text-3xl font-bold text-orange-600">{{ is_numeric($stats['lemak_avg'] ?? null) && $stats['lemak_avg'] != 0 ? number_format($stats['lemak_avg'], 1) : 'N/A' }}</p>
                                <p class="text-xs text-gray-500 mt-2">Target: 50-70g</p>
                                @if(is_numeric($stats['lemak_avg'] ?? null) && $stats['lemak_avg'] != 0)
                                <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-orange-600 h-2 rounded-full" style="width: {{ min(100, (($stats['lemak_avg'] ?? 0) / 70) * 100) }}%"></div>
                                </div>
                                @else
                                <p class="text-xs text-gray-400 mt-3">Belum ada data nutrisi</p>
                                @endif
                            </div>
                        </div>

                        <!-- Rekomendasi Diet -->
                        <div class="mt-8 bg-purple-50 border-l-4 border-purple-500 rounded-lg p-6">
                            <h3 class="font-bold text-purple-900 mb-3">Rekomendasi Diet</h3>
                            <ul class="space-y-2 text-sm text-purple-800 list-disc list-inside">
                                <li>Konsumsi protein sudah {{ $stats['protein_avg'] ?? 0 }} / hari (target: 80-100g)</li>
                                <li>Asupan karbohidrat {{ $stats['karbo_avg'] ?? 0 }} / hari (perbaharui untuk 200-300g/hari)</li>
                                <li>Konsumsi sayur dan buah minimal 5 porsi per hari</li>
                                <li>Minum air putih minimal 8 gelas per hari untuk hidrasi optimal</li>
                                <li>Hindari makanan olahan dan tinggi gula untuk kesehatan yang lebih baik</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Rekomendasi & Target Kesehatan -->
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Detail Pelacak Tidur</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <!-- Total Tidur Periode -->
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border-l-4 border-purple-500">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-moon text-purple-600 text-2xl"></i>
                                    <p class="text-gray-600 text-sm font-semibold">Total Tidur Periode</p>
                                </div>
                                <p class="text-3xl font-bold text-purple-600">{{ $stats['tidur_periode_total'] ?? 0 }}</p>
                                <p class="text-xs text-gray-500">{{ $stats['tidur_periode_count'] ?? 0 }} hari</p>
                            </div>

                            <!-- Rata-rata Tidur Harian -->
                            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-6 border-l-4 border-indigo-500">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-bed text-indigo-600 text-2xl"></i>
                                    <p class="text-gray-600 text-sm font-semibold">Rata-rata/Hari</p>
                                </div>
                                <p class="text-3xl font-bold text-indigo-600">{{ $stats['tidur_periode_avg'] ?? '-' }}</p>
                                <p class="text-xs text-gray-500">jam/malam (Target: 8 jam)</p>
                            </div>

                            <!-- Status Tidur -->
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border-l-4 border-blue-500">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-heart-pulse text-blue-600 text-2xl"></i>
                                    <p class="text-gray-600 text-sm font-semibold">Status Tidur</p>
                                </div>
                                @if($stats['tidur_periode_avg'] !== '-' && $stats['tidur_periode_avg'] >= 7)
                                    <p class="text-xl font-bold text-green-600">✅ Berkualitas</p>
                                    <p class="text-xs text-gray-500">Tidur Anda sudah optimal</p>
                                @elseif($stats['tidur_periode_avg'] !== '-' && $stats['tidur_periode_avg'] >= 6)
                                    <p class="text-xl font-bold text-yellow-600">⚠️ Cukup</p>
                                    <p class="text-xs text-gray-500">Tingkatkan durasi tidur</p>
                                @else
                                    <p class="text-xl font-bold text-red-600">❌ Kurang</p>
                                    <p class="text-xs text-gray-500">Sangat perlu ditingkatkan</p>
                                @endif
                            </div>
                        </div>

                        <!-- Riwayat Tidur Terakhir -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-calendar-days text-purple-600"></i>
                                Riwayat Tidur 7 Hari Terakhir
                            </h3>
                            @if($tidurPeriode && $tidurPeriode->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead class="bg-purple-100">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-purple-900">Tanggal</th>
                                                <th class="px-4 py-2 text-center text-purple-900">Durasi (jam)</th>
                                                <th class="px-4 py-2 text-center text-purple-900">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tidurPeriode->reverse()->take(7) as $tidur)
                                            <tr class="border-b hover:bg-purple-50">
                                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($tidur->tanggal)->format('d M Y') }}</td>
                                                <td class="px-4 py-3 text-center font-semibold text-purple-600">{{ number_format($tidur->durasi_jam, 1) }}</td>
                                                <td class="px-4 py-3 text-center">
                                                    @if($tidur->durasi_jam >= 7)
                                                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">✅ Baik</span>
                                                    @elseif($tidur->durasi_jam >= 6)
                                                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">⚠️ Cukup</span>
                                                    @else
                                                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold">❌ Kurang</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-4">Belum ada data tidur. Mulai catat tidur Anda di <a href="{{ route('tidur.analisis') }}" class="text-purple-600 font-bold hover:underline">Pelacak Tidur</a></p>
                            @endif
                        </div>
                    </div>

                    <!-- Rekomendasi & Target Kesehatan -->
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Rekomendasi & Target Kesehatan</h2>
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Target Berat Badan -->
                            <div class="bg-teal-50 border-l-4 border-teal-500 rounded-lg p-6">
                                <div class="flex items-center gap-2 mb-3">
                                    <i class="fas fa-weight text-teal-600 text-2xl"></i>
                                    <h3 class="font-bold text-teal-900 text-lg">Target Berat Badan</h3>
                                </div>
                                <p class="text-teal-800 text-sm">Berat badan Anda saat ini {{ $stats['berat_hari'] ?? '-' }} kg. Target ideal adalah {{ $user->tinggi ? round(22.5 * (($user->tinggi/100)**2), 1) : '-' }} kg sesuai IMT normal. Pertahankan pola makan sehat dan olahraga teratur untuk mencapai target.</p>
                            </div>

                            <!-- Target Tidur -->
                            <div class="bg-purple-50 border-l-4 border-purple-500 rounded-lg p-6">
                                <div class="flex items-center gap-2 mb-3">
                                    <i class="fas fa-moon text-purple-600 text-2xl"></i>
                                    <h3 class="font-bold text-purple-900 text-lg">Target Tidur</h3>
                                </div>
                                <p class="text-purple-800 text-sm">Durasi tidur Anda saat ini {{ $stats['tidur_periode_avg'] ?? '-' }} jam/malam. Pertahankan konsistensi waktu tidur. Coba tidur dan bangun pada jam yang sama setiap hari untuk irama sirkadian yang optimal.</p>
                            </div>

                            <!-- Target Olahraga -->
                            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-6">
                                <div class="flex items-center gap-2 mb-3">
                                    <i class="fas fa-dumbbell text-green-600 text-2xl"></i>
                                    <h3 class="font-bold text-green-900 text-lg">Target Olahraga</h3>
                                </div>
                                <p class="text-green-800 text-sm">Aktivitas fisik Anda saat ini {{ $stats['olahraga_periode_avg'] ?? '-' }} menit/hari. Tingkatkan aktivitas fisik hingga 150 menit per minggu. Alternatif: lakukan olahraga ringan-sedang 150 menit per minggunya atau olahraga berat 75 menit per minggu.</p>
                            </div>

                            <!-- Target Nutrisi -->
                            <div class="bg-orange-50 border-l-4 border-orange-500 rounded-lg p-6">
                                <div class="flex items-center gap-2 mb-3">
                                    <i class="fas fa-leaf text-orange-600 text-2xl"></i>
                                    <h3 class="font-bold text-orange-900 text-lg">Target Nutrisi</h3>
                                </div>
                                <p class="text-orange-800 text-sm">Jaga keseimbangan nutrisi. Protein 80-100g, Karbo 200-300g, Lemak 50-70g. Konsumsi makanan bervariasi untuk mendapatkan nutrisi lengkap dari sayur, buah, biji-bijian, dan protein hewani maupun nabati.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Kesehatan -->
                    <div class="bg-gradient-to-r from-cyan-500 to-teal-600 rounded-lg shadow-lg p-8 text-white">
                        <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                            <i class="fas fa-heart"></i>Tips Kesehatan
                        </h2>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-1"></i>
                                <span>Konsumsi dengan bijak kalori sesuai kebutuhan dan tujuan kesehatan Anda</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-1"></i>
                                <span>Cukup olahraga Anda setiap hari untuk menjaga kesehatan jantung dan berat badan</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-1"></i>
                                <span>Istirahat dengan nyaman setiap malam minimal 7-8 jam per hari</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-1"></i>
                                <span>Hidrasi dengan air putih bersih, pastikan minum air 8 gelas per hari</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-1"></i>
                                <span>Hindari makanan berlebihan dengan rasa asin atau manis yang berlebihan</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
