@extends('layouts.app')

@section('title', 'Kalori Harian - FitPlus')

@section('content')
    <h2>Total Kalori Hari Ini</h2>
    
    <div class="card">
        <div style="text-align: center;">
            <h1 style="color: #3498db; font-size: 3rem;">{{ $totalKalori ?? 0 }} kkal</h1>
            <p style="color: #666; margin-top: 0.5rem;">dari estimasi {{ $estimasi ?? 2000 }} kkal</p>
        </div>

        <div style="margin-top: 2rem; width: 100%; height: 20px; background: #e0e0e0; border-radius: 10px; overflow: hidden;">
            <div style="height: 100%; background: #3498db; width: {{ min(($totalKalori ?? 0) / (max($estimasi ?? 2000, 1)) * 100, 100) }}%;"></div>
        </div>
    </div>

    <div style="margin-top: 2rem;">
        <a href="{{ route('makanan.gizi') }}" class="btn btn-primary">Tambah Makanan</a>
        <a href="{{ route('dashboard') }}" class="btn" style="background: #95a5a6; color: white; margin-left: 0.5rem;">Kembali</a>
    </div>
@endsection