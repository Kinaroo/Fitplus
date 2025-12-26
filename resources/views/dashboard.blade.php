@extends('layouts.app')

@section('title', 'Dashboard - FitPlus')

@section('content')
    <h1>Dashboard</h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
        <div class="card">
            <h3>Kalori Harian</h3>
            <p style="font-size: 2rem; color: #3498db; margin-top: 1rem;">
                {{ $totalKalori ?? 0 }} / {{ $estimasiKalori ?? 2000 }}
            </p>
            <p style="color: #666;">kkal</p>
            <a href="{{ route('kalori.harian') }}" class="btn btn-primary" style="margin-top: 1rem;">Lihat Detail</a>
        </div>

        <div class="card">
            <h3>Tambah Makanan</h3>
            <p style="color: #666; margin-top: 1rem;">Catat asupan kalori harian Anda</p>
            <a href="{{ route('makanan.gizi') }}" class="btn btn-primary" style="margin-top: 1rem;">Tambah Makanan</a>
        </div>

        <div class="card">
            <h3>Tantangan</h3>
            <p style="color: #666; margin-top: 1rem;">Buat dan pantau tantangan fitness Anda</p>
            <a href="{{ route('tantangan.progres') }}" class="btn btn-primary" style="margin-top: 1rem;">Lihat Tantangan</a>
        </div>

        <div class="card">
            <h3>Tidur</h3>
            <p style="color: #666; margin-top: 1rem;">Pantau pola tidur harian</p>
            <a href="{{ route('tidur.analisis') }}" class="btn btn-primary" style="margin-top: 1rem;">Analisis Tidur</a>
        </div>

        <div class="card">
            <h3>Rekomendasi Latihan</h3>
            <p style="color: #666; margin-top: 1rem;">Rekomendasi workout berdasarkan IMT Anda</p>
            <a href="{{ route('rekomendasi.workout') }}" class="btn btn-primary" style="margin-top: 1rem;">Lihat
                Rekomendasi</a>
        </div>

        <div class="card">
            <h3>Rencana Latihan</h3>
            <p style="color: #666; margin-top: 1rem;">Rencana workout berdasarkan IMT Anda</p>
            <a href="{{ route('training.plan') }}" class="btn btn-primary" style="margin-top: 1rem;">Lihat
                Rencana</a>
        </div>

        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <h3 style="color: white;">📊 Laporan Mingguan</h3>
            <p style="color: rgba(255,255,255,0.9); margin-top: 1rem;">Lihat ringkasan diet, tidur, dan workout Anda dalam seminggu terakhir</p>
            <a href="{{ route('laporan.mingguan') }}" class="btn" style="margin-top: 1rem; background: white; color: #667eea;">Lihat Laporan</a>
        </div>

        @if(auth()->check() && (auth()->user()->is_admin ?? 0) == 1)
            <div class="card" style="grid-column: 1 / -1; margin-top: 1rem;">
                <h3>Admin Panel</h3>
                <div style="display:flex; gap:1rem; flex-wrap:wrap; margin-top:0.75rem;">
                    <a class="btn btn-secondary" href="{{ route('admin.tantangan.index') }}">Manage Tantangan</a>
                    <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">Manage Users</a>
                </div>
                <p style="color:#666; margin-top:0.5rem;">Only visible to administrators.</p>
            </div>
        @endif

    </div>
@endsection