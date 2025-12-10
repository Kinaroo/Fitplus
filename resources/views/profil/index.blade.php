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
                <input type="text" value="{{ auth()->user()->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}" disabled
                    style="background: #f5f5f5;">
            </div>

            <div class="form-group">
                <label for="tinggi">Tinggi Badan (cm)</label>
                <input type="number" id="tinggi" name="tinggi" value="{{ auth()->user()->tinggi }}" min="100" max="250"
                    required>
                @error('tinggi') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="berat">Berat Badan (kg)</label>
                <input type="number" id="berat" name="berat" value="{{ auth()->user()->berat }}" min="20" max="300"
                    step="0.1" required>
                @error('berat') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="tingkat_aktivitas">Tingkat Aktivitas Harian</label>
                <select id="tingkat_aktivitas" name="tingkat_aktivitas" required>
                    <option value="">-- Pilih Tingkat Aktivitas --</option>
                    <option value="low" {{ auth()->user()->tingkat_aktivitas === 'low' ? 'selected' : '' }}>
                        Rendah (Jarang olahraga, kerja kantoran)
                    </option>
                    <option value="mid" {{ auth()->user()->tingkat_aktivitas === 'mid' ? 'selected' : '' }}>
                        Sedang (Olahraga 3-4x seminggu)
                    </option>
                    <option value="high" {{ auth()->user()->tingkat_aktivitas === 'high' ? 'selected' : '' }}>
                        Tinggi (Olahraga intensif 5+ hari seminggu)
                    </option>
                </select>
                @error('tingkat_aktivitas') <span class="error">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
@endsection