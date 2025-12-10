@extends('layouts.app')

@section('title', 'Rencana Latihan - FitPlus')

@section('content')
    <h1>Rencana Latihan Personal Anda</h1>

    <!-- User Metrics Summary -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="card">
            <p style="color: #666; font-size: 0.9rem;">BMI</p>
            <h2 style="color: #3498db; margin: 0.5rem 0;">{{ $bmi }}</h2>
            <p style="margin: 0; color: #666; font-size: 0.9rem;">{{ $trainingPlan['kategori_bmi'] }}</p>
        </div>
        
        <div class="card">
            <p style="color: #666; font-size: 0.9rem;">Berat Badan</p>
            <h2 style="color: #e74c3c; margin: 0.5rem 0;">{{ $trainingPlan['berat_badan'] }} kg</h2>
            <p style="margin: 0; color: #666; font-size: 0.9rem;">Tinggi: {{ $trainingPlan['tinggi_badan'] }} cm</p>
        </div>
        
        <div class="card">
            <p style="color: #666; font-size: 0.9rem;">Kalori Hari Ini</p>
            <h2 style="color: #27ae60; margin: 0.5rem 0;">{{ number_format($totalKaloriHariIni, 0) }} kkal</h2>
            <p style="margin: 0; color: #666; font-size: 0.9rem;">Target: {{ number_format($estimasiKaloriHarian, 0) }} kkal</p>
        </div>

        <div class="card" style="background: {{ $kaloriDefisit >= 0 ? '#d4edda' : '#f8d7da' }};">
            <p style="color: #666; font-size: 0.9rem;">Kalori {{ $kaloriDefisit >= 0 ? 'Tersisa' : 'Berlebih' }}</p>
            <h2 style="color: {{ $kaloriDefisit >= 0 ? '#27ae60' : '#e74c3c' }}; margin: 0.5rem 0;">{{ number_format(abs($kaloriDefisit), 0) }} kkal</h2>
            <p style="margin: 0; color: #666; font-size: 0.9rem;">{{ $kaloriDefisit >= 0 ? 'Bisa ditambah' : 'Berlebihan' }}</p>
        </div>
    </div>

    <!-- Target -->
    <div class="card" style="background: #ecf0f1; margin-bottom: 2rem;">
        <h3 style="color: #2c3e50; margin: 0;">📋 Target Program: {{ $trainingPlan['target'] }}</h3>
        <p style="margin-top: 0.5rem; color: #555;">Program latihan disesuaikan dengan BMI, kalori konsumsi, dan target kesehatan Anda.</p>
    </div>

    <!-- Weekly Training Schedule -->
    <div>
        <h2 style="margin-bottom: 1.5rem;">📅 Jadwal Latihan Mingguan</h2>
        
        @foreach($trainingPlan['workouts'] as $workout)
            <div class="card" style="margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 2px solid #e0e0e0; padding-bottom: 1rem;">
                    <div>
                        <h3 style="margin: 0; color: #2c3e50;">{{ $workout['hari'] }}</h3>
                        <p style="margin: 0.25rem 0 0 0; color: #666; font-size: 0.95rem;">{{ $workout['fokus'] }}</p>
                    </div>
                    <div style="text-align: right;">
                        <p style="margin: 0; font-weight: bold; color: #3498db;">{{ $workout['durasi'] }}</p>
                        <p style="margin: 0.25rem 0 0 0; color: #27ae60; font-weight: bold;">🔥 {{ $workout['kalori_terbakar'] }} kkal</p>
                    </div>
                </div>

                <div style="margin-top: 1rem;">
                    @foreach($workout['exercises'] as $exercise)
                        <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f0f0f0;">
                            <div>
                                <p style="margin: 0; font-weight: 500; color: #2c3e50;">{{ $exercise['nama'] }}</p>
                            </div>
                            <div style="color: #666; font-size: 0.9rem; text-align: right;">
                                <span style="background: #e8f4f8; padding: 0.25rem 0.75rem; border-radius: 3px;">
                                    {{ $exercise['sets'] }} set × {{ $exercise['reps'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Recommendations -->
    <div class="card" style="background: #fff3cd; border-left: 4px solid #ffc107; margin-top: 2rem;">
        <h3 style="color: #856404; margin-top: 0;">💡 Rekomendasi</h3>
        <ul style="color: #856404; margin-bottom: 0;">
            <li>Konsumsi protein yang cukup untuk mendukung recovery otot</li>
            <li>Minum air minimal 8-10 gelas per hari</li>
            <li>Tidur minimal 7-8 jam setiap malam</li>
            <li>Jangan melewatkan warm-up dan cool-down</li>
            <li>Istirahat yang cukup di antara sesi latihan</li>
            <li>Konsultasikan dengan personal trainer jika perlu bantuan teknik</li>
        </ul>
    </div>

    <div style="margin-top: 2rem;">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">← Kembali ke Dashboard</a>
    </div>
@endsection