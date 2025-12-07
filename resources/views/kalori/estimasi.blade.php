@extends('layouts.app')

@section('title', 'Estimasi Kalori - FitPlus')

@section('content')
    <div class="card">
        <h2>Estimasi Kalori Harian</h2>
        
        <div style="margin-top: 2rem; font-size: 1.25rem;">
            <p>Berdasarkan profil Anda, kebutuhan kalori harian diperkirakan:</p>
            <h3 style="color: #3498db; font-size: 2.5rem; margin-top: 1rem;">{{ $estimasi ?? 2000 }} kkal</h3>
        </div>

        <div style="margin-top: 2rem; background: #f9f9f9; padding: 1rem; border-radius: 4px;">
            <p><strong>Catatan:</strong> Estimasi ini didasarkan pada tinggi badan, berat badan, dan tingkat aktivitas Anda. Untuk hasil yang lebih akurat, konsultasikan dengan ahli gizi profesional.</p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-primary" style="margin-top: 1rem;">Kembali ke Dashboard</a>
    </div>
@endsection