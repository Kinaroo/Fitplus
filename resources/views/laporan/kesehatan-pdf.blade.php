<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kesehatan - {{ $user->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #06b6d4;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #0d9488;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .section {
            margin: 20px 0;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #f0f9ff;
            color: #0d9488;
            padding: 10px 15px;
            font-weight: bold;
            border-left: 4px solid #06b6d4;
            margin-bottom: 15px;
        }
        .stat-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .stat-item {
            display: table-cell;
            width: 25%;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .stat-label {
            font-weight: bold;
            color: #0d9488;
            margin-bottom: 5px;
        }
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .stat-unit {
            font-size: 12px;
            color: #666;
        }
        .recommendation {
            background-color: #ecfdf5;
            border-left: 4px solid #10b981;
            padding: 12px 15px;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #999;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th {
            background-color: #f3f4f6;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #06b6d4;
            font-weight: bold;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>❤️ LAPORAN KESEHATAN BERKALA</h1>
        <p><strong>{{ $user->nama }}</strong></p>
        <p>Tanggal: {{ now()->locale('id')->format('d F Y') }}</p>
        <p>Periode: {{ $periode }} hari terakhir</p>
    </div>

    <!-- Data Profil -->
    <div class="section">
        <div class="section-title">Informasi Profil</div>
        <table>
            <tr>
                <td width="40%"><strong>Nama</strong></td>
                <td>{{ $user->nama }}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td><strong>Jenis Kelamin</strong></td>
                <td>{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td><strong>Tinggi Badan</strong></td>
                <td>{{ $user->tinggi ?? '-' }} cm</td>
            </tr>
        </table>
    </div>

    <!-- Statistik Harian -->
    <div class="section">
        <div class="section-title">Statistik Hari Ini</div>
        <div class="stat-grid">
            <div class="stat-item">
                <div class="stat-label">Berat Badan</div>
                <div class="stat-value">{{ $stats['berat_hari'] ?? '-' }}</div>
                <div class="stat-unit">kg</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Durasi Tidur</div>
                <div class="stat-value">{{ $stats['tidur_hari'] ?? '-' }}</div>
                <div class="stat-unit">jam</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total Kalori</div>
                <div class="stat-value">{{ $stats['kalori_hari'] ?? '-' }}</div>
                <div class="stat-unit">kcal</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Indeks Massa Tubuh</div>
                <div class="stat-value">{{ $stats['imt'] ?? '-' }}</div>
                <div class="stat-unit">{{ $stats['kategori_imt'] ?? '' }}</div>
            </div>
        </div>
    </div>

    <!-- Statistik Periode -->
    <div class="section">
        <div class="section-title">Rata-rata Periode ({{ $periode }} Hari)</div>
        <div class="stat-grid">
            <div class="stat-item">
                <div class="stat-label">Rata-rata Berat</div>
                <div class="stat-value">{{ $stats['berat_periode'] ?? '-' }}</div>
                <div class="stat-unit">kg</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Rata-rata Tidur</div>
                <div class="stat-value">{{ $stats['tidur_periode'] ?? '-' }}</div>
                <div class="stat-unit">jam</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Rata-rata Kalori</div>
                <div class="stat-value">{{ $stats['kalori_periode'] ?? '-' }}</div>
                <div class="stat-unit">kcal</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total Olahraga</div>
                <div class="stat-value">{{ $stats['olahraga_total'] ?? '-' }}</div>
                <div class="stat-unit">kali</div>
            </div>
        </div>
    </div>

    <!-- Rekomendasi -->
    @if(isset($stats['rekomendasi']) && !empty($stats['rekomendasi']))
    <div class="section">
        <div class="section-title">Rekomendasi Kesehatan</div>
        @foreach($stats['rekomendasi'] as $rekomendasi)
            <div class="recommendation">
                <strong>{{ $rekomendasi['judul'] }}</strong><br/>
                {{ $rekomendasi['deskripsi'] }}
            </div>
        @endforeach
    </div>
    @endif

    <!-- Detail Aktivitas -->
    @if($aktivitasPeriode->count() > 0)
    <div class="section">
        <div class="section-title">Riwayat Berat Badan ({{ $periode }} Hari)</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Berat (kg)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aktivitasPeriode->take(20) as $aktivitas)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($aktivitas->tanggal)->locale('id')->format('d F Y') }}</td>
                        <td>{{ $aktivitas->berat ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align: center; color: #999;">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    <!-- Detail Tidur -->
    @if($tidurPeriode->count() > 0)
    <div class="section">
        <div class="section-title">Riwayat Tidur ({{ $periode }} Hari)</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Durasi (Jam)</th>
                    <th>Kualitas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tidurPeriode->take(20) as $tidur)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($tidur->tanggal)->locale('id')->format('d F Y') }}</td>
                        <td>{{ $tidur->durasi_jam ?? '-' }}</td>
                        <td>{{ ucfirst($tidur->kualitas ?? '-') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #999;">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini digenerate oleh sistem FitPlus pada {{ now()->locale('id')->format('d F Y H:i') }}</p>
        <p>Untuk informasi lebih lanjut, hubungi administrator sistem kesehatan Anda</p>
    </div>
</body>
</html>
