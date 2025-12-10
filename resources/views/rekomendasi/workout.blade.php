@extends('layouts.app')

@section('title', 'Rekomendasi Workout - FitPlus')

@section('content')
    <h1>Rekomendasi Latihan Personalisasi</h1>

    <div style="display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem;">
        <div class="card" style="min-width:200px;">
            <p style="color:#666; margin:0; font-size:0.9rem;">IMT Anda</p>
            <h2 style="color:#3498db; margin:0.25rem 0;">{{ number_format($imt, 1) }}</h2>
            <p style="color:#666; font-size:0.9rem; margin:0;">Kategori: <strong>{{ $kategori }}</strong></p>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card" style="background:#ecf0f1; margin-bottom:1.5rem;">
        <h3 style="margin-top:0;">Filter Rekomendasi</h3>
        <form method="GET" action="{{ route('rekomendasi.workout') }}" style="display:flex; flex-direction:column; gap:1rem;">
            
            <div>
                <label for="experience" style="display:block; margin-bottom:0.5rem; font-weight:500;">Tingkat Pengalaman</label>
                <select name="experience" id="experience" style="padding:0.5rem; border:1px solid #bdc3c7; border-radius:4px; width:100%; max-width:300px;">
                    <option value="beginner" {{ $experience === 'beginner' ? 'selected' : '' }}>Pemula</option>
                    <option value="intermediate" {{ $experience === 'intermediate' ? 'selected' : '' }}>Menengah</option>
                    <option value="advanced" {{ $experience === 'advanced' ? 'selected' : '' }}>Advanced</option>
                    <option value="all" {{ $experience === 'all' ? 'selected' : '' }}>Semua Level</option>
                </select>
            </div>

            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:500;">Bagian Tubuh yang Ingin Dilatih</label>
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px, 1fr)); gap:0.5rem;">
                    @foreach($bodyParts as $key => $name)
                        <label style="display:flex; align-items:center; gap:0.5rem;">
                            <input type="checkbox" name="body_parts[]" value="{{ $key }}"
                                {{ in_array($key, $selectedBodyParts) ? 'checked' : '' }}>
                            <span>{{ $name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div style="display:flex; gap:0.5rem;">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>

    <!-- Workouts Grouped by Muscle -->
    <div>
        @forelse($workoutsByMuscle as $muscle => $exercises)
            <div class="card" style="margin-bottom:1.5rem;">
                <h3 style="margin-top:0; color:#2c3e50; border-bottom:2px solid #3498db; padding-bottom:0.5rem;">
                    💪 {{ ucfirst($muscle) }}
                </h3>
                
                <div style="margin-top:1rem;">
                    @foreach($exercises->take(5) as $exercise)
                        <div style="display:grid; grid-template-columns:1fr auto; gap:1rem; padding:0.75rem; border-bottom:1px solid #ecf0f1; align-items:center;">
                            <div>
                                <p style="margin:0; font-weight:500; color:#2c3e50;">
                                    {{ $exercise->getName() }}
                                </p>
                                <div style="display:flex; gap:0.5rem; margin-top:0.25rem; flex-wrap:wrap;">
                                    <span style="background:#e8f4f8; color:#2980b9; padding:0.25rem 0.5rem; border-radius:3px; font-size:0.85rem;">
                                        {{ ucfirst($exercise->getForce()) }}
                                    </span>
                                    <span style="background:#fef5e7; color:#d68910; padding:0.25rem 0.5rem; border-radius:3px; font-size:0.85rem;">
                                        {{ ucfirst($exercise->getLevel()) }}
                                    </span>
                                </div>
                            </div>
                            <div style="text-align:right;">
                                <p style="margin:0; color:#27ae60; font-weight:bold;">{{ ucfirst($exercise->getCategory()) }}</p>
                            </div>
                        </div>
                    @endforeach
                    @if($exercises->count() > 5)
                        <p style="color:#7f8c8d; font-size:0.9rem; padding:0.5rem; margin:0;">+{{ $exercises->count() - 5 }} latihan lainnya</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="card" style="background:#fff3cd; border-left:4px solid #ffc107;">
                <p style="margin:0; color:#856404;">Belum ada rekomendasi latihan untuk kombinasi IMT dan level pengalaman Anda. Coba ubah filter.</p>
            </div>
        @endforelse
    </div>

    <!-- Generate Training Plan -->
    <div class="card" style="background:#e8f8f5; border-left:4px solid #16a085; margin-top:2rem;">
        <h3 style="color:#117a65; margin-top:0;">📋 Buat Rencana Latihan Personal</h3>
        <p style="color:#1e8449;">Buat rencana latihan mingguan yang disesuaikan dengan BMI, pengalaman, dan target tubuh Anda.</p>
        <a href="{{ route('training.plan') }}" class="btn btn-primary">Buat Rencana Latihan</a>
    </div>

    <!-- Tips -->
    <div class="card" style="background:#e8f8f5; border-left:4px solid #16a085; margin-top:1rem;">
        <h3 style="color:#117a65; margin-top:0;">💡 Tips Latihan</h3>
        <ul style="color:#1e8449; margin-bottom:0;">
            <li>Mulai dengan weight yang ringan dan tingkatkan secara bertahap</li>
            <li>Lakukan warm-up 5-10 menit sebelum latihan utama</li>
            <li>Rest 48 jam untuk muscle group yang sama sebelum latihan lagi</li>
            <li>Konsultasikan dengan personal trainer untuk form yang tepat</li>
            <li>Jangan skip cool-down dan stretching setelah latihan</li>
        </ul>
    </div>

    <div style="margin-top:1.5rem;">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">← Kembali ke Dashboard</a>
    </div>
@endsection