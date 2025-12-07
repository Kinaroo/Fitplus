@extends('layouts.app')

@section('title', 'Profil - FitPlus')

@section('content')
    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2>Profil Saya</h2>
        
        <form action="{{ route('profil.update') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Nama</label>
                <input type="text" value="{{ auth()->user()->nama }}" disabled style="background: #f5f5f5;">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" value="{{ auth()->user()->email }}" disabled style="background: #f5f5f5;">
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <input type="text" value="{{ auth()->user()->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}" disabled style="background: #f5f5f5;">
            </div>

            <div class="form-group">
                <label for="tinggi_badan">Tinggi Badan (cm)</label>
                <input type="number" id="tinggi_badan" name="tinggi_badan" 
                       value="{{ auth()->user()->tinggi_badan }}" 
                       min="100" max="250" required>
                @error('tinggi_badan') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="berat_badan">Berat Badan (kg)</label>
                <input type="number" id="berat_badan" name="berat_badan" 
                       value="{{ auth()->user()->berat_badan }}" 
                       min="20" max="300" step="0.1" required>
                @error('berat_badan') <span class="error">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
@endsection