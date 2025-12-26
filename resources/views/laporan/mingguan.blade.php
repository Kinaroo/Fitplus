@extends('layouts.app')

@section('title', 'Laporan Mingguan - FitPlus')

@section('content')
<style>
    .report-header {
        background: linear-gradient(135deg, #3498db, #2c3e50);
        color: white;
        padding: 2rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        text-align: center;
    }
    .report-header h1 { color: white; margin-bottom: 0.5rem; }
    .report-header p { opacity: 0.9; margin: 0; }
    
    .score-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .score-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .score-card.overall {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        color: white;
    }
    .score-card.overall h3 { color: white; }
    .score-value {
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0.5rem 0;
    }
    .score-card.diet .score-value { color: #e74c3c; }
    .score-card.sleep .score-value { color: #9b59b6; }
    .score-card.workout .score-value { color: #f39c12; }
    .score-card.overall .score-value { color: white; }
    .score-label { font-size: 0.9rem; color: #666; }
    .score-card.overall .score-label { color: rgba(255,255,255,0.9); }

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .section-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }
    .section-icon.diet { background: #e74c3c; }
    .section-icon.sleep { background: #9b59b6; }
    .section-icon.workout { background: #f39c12; }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }
    .data-table th, .data-table td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    .data-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #2c3e50;
    }
    .data-table tr:hover { background: #f8f9fa; }

    .summary-box {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }
    .summary-row:last-child { border-bottom: none; }
    .summary-label { color: #666; }
    .summary-value { font-weight: bold; color: #2c3e50; }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: #eee;
        border-radius: 4px;
        overflow: hidden;
        margin-top: 0.5rem;
    }
    .progress-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.3s ease;
    }
    .progress-fill.diet { background: #e74c3c; }
    .progress-fill.sleep { background: #9b59b6; }
    .progress-fill.workout { background: #f39c12; }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #666;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .badge-success { background: #d4edda; color: #155724; }
    .badge-warning { background: #fff3cd; color: #856404; }
    .badge-danger { background: #f8d7da; color: #721c24; }

    .aktivitas-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
    }
    .aktivitas-tag {
        background: #e9ecef;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
    }
</style>

<div class="report-header">
    <h1>📊 Laporan Mingguan</h1>
    <p>{{ $startOfWeek->format('d M Y') }} - {{ $endOfWeek->format('d M Y') }}</p>
</div>

<!-- Overall Scores -->
<div class="score-cards">
    <div class="score-card overall">
        <h3>Skor Total</h3>
        <div class="score-value">{{ $overallScore }}%</div>
        <div class="score-label">Performa Minggu Ini</div>
    </div>
    <div class="score-card diet">
        <h3>Diet</h3>
        <div class="score-value">{{ $dietScore }}%</div>
        <div class="score-label">Target Kalori</div>
        <div class="progress-bar">
            <div class="progress-fill diet" style="width: {{ $dietScore }}%"></div>
        </div>
    </div>
    <div class="score-card sleep">
        <h3>Tidur</h3>
        <div class="score-value">{{ $sleepScore }}%</div>
        <div class="score-label">Kualitas: {{ $sleepQuality }}</div>
        <div class="progress-bar">
            <div class="progress-fill sleep" style="width: {{ $sleepScore }}%"></div>
        </div>
    </div>
    <div class="score-card workout">
        <h3>Workout</h3>
        <div class="score-value">{{ $workoutScore }}%</div>
        <div class="score-label">{{ $daysWithWorkout }}/5 Hari</div>
        <div class="progress-bar">
            <div class="progress-fill workout" style="width: {{ $workoutScore }}%"></div>
        </div>
    </div>
</div>

<!-- Diet Section -->
<div class="card">
    <div class="section-title">
        <div class="section-icon diet">🍽️</div>
        <h2>Ringkasan Diet</h2>
    </div>
    
    <div class="summary-box">
        <div class="summary-row">
            <span class="summary-label">Total Kalori Minggu Ini</span>
            <span class="summary-value">{{ number_format($totalKaloriWeek) }} kkal</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Rata-rata Kalori Harian</span>
            <span class="summary-value">{{ number_format($avgKalori) }} kkal</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Target Harian</span>
            <span class="summary-value">{{ number_format($estimasiKalori) }} kkal</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Rata-rata Protein</span>
            <span class="summary-value">{{ $avgProtein }}g</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Rata-rata Karbohidrat</span>
            <span class="summary-value">{{ $avgKarbohidrat }}g</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Rata-rata Lemak</span>
            <span class="summary-value">{{ $avgLemak }}g</span>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Kalori</th>
                <th>Protein</th>
                <th>Karbo</th>
                <th>Lemak</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dietPerDay as $day)
            <tr>
                <td>{{ $day['day'] }}</td>
                <td>{{ $day['date'] }}</td>
                <td>{{ number_format($day['kalori']) }} kkal</td>
                <td>{{ $day['protein'] }}g</td>
                <td>{{ $day['karbohidrat'] }}g</td>
                <td>{{ $day['lemak'] }}g</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Sleep Section -->
<div class="card">
    <div class="section-title">
        <div class="section-icon sleep">😴</div>
        <h2>Ringkasan Tidur</h2>
    </div>

    <div class="summary-box">
        <div class="summary-row">
            <span class="summary-label">Total Jam Tidur</span>
            <span class="summary-value">{{ number_format($totalDurasiWeek, 1) }} jam</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Rata-rata Tidur/Hari</span>
            <span class="summary-value">{{ $avgSleep }} jam</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Kualitas Tidur</span>
            <span class="summary-value">
                @if($sleepQuality == 'Baik')
                    <span class="badge badge-success">{{ $sleepQuality }}</span>
                @elseif($sleepQuality == 'Kurang')
                    <span class="badge badge-danger">{{ $sleepQuality }}</span>
                @else
                    <span class="badge badge-warning">{{ $sleepQuality }}</span>
                @endif
            </span>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Durasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sleepPerDay as $day)
            <tr>
                <td>{{ $day['day'] }}</td>
                <td>{{ $day['date'] }}</td>
                <td>{{ $day['durasi'] > 0 ? $day['durasi'] . ' jam' : '-' }}</td>
                <td>
                    @if($day['analisis'] == 'Normal')
                        <span class="badge badge-success">{{ $day['analisis'] }}</span>
                    @elseif($day['analisis'] == 'Kurang tidur')
                        <span class="badge badge-danger">{{ $day['analisis'] }}</span>
                    @elseif($day['analisis'] == 'Tidur berlebihan')
                        <span class="badge badge-warning">{{ $day['analisis'] }}</span>
                    @else
                        <span style="color: #999;">{{ $day['analisis'] }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Workout Section -->
<div class="card">
    <div class="section-title">
        <div class="section-icon workout">💪</div>
        <h2>Ringkasan Workout</h2>
    </div>

    <div class="summary-box">
        <div class="summary-row">
            <span class="summary-label">Hari Aktif</span>
            <span class="summary-value">{{ $daysWithWorkout }} hari</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Total Durasi</span>
            <span class="summary-value">{{ $totalDurasiWorkout }} menit</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Total Kalori Terbakar</span>
            <span class="summary-value">{{ number_format($totalKaloriTerbakar) }} kkal</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Rata-rata Durasi/Sesi</span>
            <span class="summary-value">{{ $avgWorkoutDuration }} menit</span>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Durasi</th>
                <th>Kalori Terbakar</th>
                <th>Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($workoutPerDay as $day)
            <tr>
                <td>{{ $day['day'] }}</td>
                <td>{{ $day['date'] }}</td>
                <td>{{ $day['durasi'] > 0 ? $day['durasi'] . ' menit' : '-' }}</td>
                <td>{{ $day['kalori_terbakar'] > 0 ? number_format($day['kalori_terbakar']) . ' kkal' : '-' }}</td>
                <td>
                    @if(count($day['aktivitas']) > 0)
                        <div class="aktivitas-list">
                            @foreach($day['aktivitas'] as $aktivitas)
                                <span class="aktivitas-tag">{{ $aktivitas }}</span>
                            @endforeach
                        </div>
                    @else
                        <span style="color: #999;">-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="text-align: center; margin-top: 2rem;">
    <a href="{{ route('dashboard') }}" class="btn btn-primary">← Kembali ke Dashboard</a>
</div>
@endsection
