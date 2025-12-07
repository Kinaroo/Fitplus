@extends('layouts.app')

@section('title', 'Detail Gizi - FitPlus')

@section('content')
    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2>{{ $gizi['nama_makanan'] }}</h2>
        
        <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 4px; margin-top: 1.5rem;">
            <p style="margin-bottom: 1rem;"><strong>Jumlah Porsi:</strong> {{ $gizi['porsi'] }}</p>
            
            <div style="border-top: 1px solid #ddd; padding-top: 1rem;">
                <p style="margin-bottom: 0.75rem;"><strong>Kalori:</strong> {{ number_format($gizi['kalori'], 0) }} kkal</p>
                <p style="margin-bottom: 0.75rem;"><strong>Protein:</strong> {{ number_format($gizi['protein'], 1) }} g</p>
                <p style="margin-bottom: 0.75rem;"><strong>Karbohidrat:</strong> {{ number_format($gizi['karbohidrat'], 1) }} g</p>
                <p style="margin-bottom: 0;"><strong>Lemak:</strong> {{ number_format($gizi['lemak'], 1) }} g</p>
            </div>
        </div>

        <a href="{{ route('makanan.tambah') }}" class="btn btn-primary" style="margin-top: 1.5rem;">Kembali</a>
    </div>
@endsection