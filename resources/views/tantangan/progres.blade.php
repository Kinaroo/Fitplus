@extends('layouts.app')

@section('title', 'Progress Tantangan - FitPlus')

@section('content')
    <h1>Progress Tantangan</h1>

    @if(isset($pesan))
        <div class="card" style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 1rem;">
            <p style="color: #856404; margin: 0;">{{ $pesan }}</p>
        </div>
    @else
        <div class="card" style="margin-bottom: 2rem;">
            <h2>{{ $tantangan->nama_tantangan ?? 'Tantangan' }}</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin: 1.5rem 0;">
                <div>
                    <p style="color: #666; margin-bottom: 0.5rem;">Status</p>
                    <p style="font-size: 1.2rem; font-weight: bold;">
                        @if($tantangan->status === 'belum')
                            <span style="color: #95a5a6;">Belum Dimulai</span>
                        @elseif($tantangan->status === 'proses')
                            <span style="color: #3498db;">Sedang Berlangsung</span>
                        @else
                            <span style="color: #27ae60;">Selesai</span>
                        @endif
                    </p>
                </div>
                
                <div>
                    <p style="color: #666; margin-bottom: 0.5rem;">Tanggal</p>
                    <p style="font-size: 1rem;">
                        {{ \Carbon\Carbon::parse($tantangan->tanggal_mulai)->format('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($tantangan->tanggal_selesai)->format('d M Y') }}
                    </p>
                </div>
            </div>

            <div style="background: #ecf0f1; padding: 1rem; border-radius: 4px; margin: 1rem 0;">
                <p style="color: #666; margin-bottom: 0.5rem;">Kalori Terbakar Hari Ini</p>
                <p style="font-size: 2rem; color: #e74c3c; margin: 0;">{{ $kaloriHariIni ?? 0 }} kkal</p>
            </div>

            @if($selesai)
                <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 1rem; border-radius: 4px; margin: 1rem 0;">
                    <p style="margin: 0;">✓ Selamat! Anda telah menyelesaikan tantangan hari ini!</p>
                </div>
            @endif

            <a href="{{ route('dashboard') }}" class="btn" style="background: #95a5a6; color: white; margin-top: 1rem;">Kembali ke Dashboard</a>
        </div>
    @endif
@endsection