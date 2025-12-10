@extends('layouts.app')

@section('title', 'Analisis Tidur - FitPlus')

@section('content')
    <div class="card" style="max-width:700px; margin:0 auto;">
        <h2>Analisis Tidur</h2>

        @if(session('success'))
            <div style="background:#d4edda; border:1px solid #c3e6cb; color:#155724; padding:1rem; border-radius:4px; margin-bottom:1rem;">
                {{ session('success') }}
            </div>
        @endif

        <div style="margin-bottom:1.25rem;">
            <form action="{{ route('tidur.simpan') }}" method="POST" id="tidurForm">
                @csrf

                <div class="form-group">
                    <label for="durasi_tidur">Durasi Tidur (jam)</label>
                    <input type="number" id="durasi_tidur" name="durasi_tidur" step="0.25" min="0.25" max="24"
                        value="{{ old('durasi_tidur') ?? '' }}" required
                        style="width:120px; padding:0.4rem; margin-right:0.75rem;" />
                    @error('durasi_tidur') <div class="error" style="color:#c0392b;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group" style="margin-top:0.75rem;">
                    <label for="kualitas_tidur">Kualitas Tidur (opsional, 1-10)</label>
                    <input type="number" id="kualitas_tidur" name="kualitas_tidur" min="1" max="10" step="1"
                        value="{{ old('kualitas_tidur') ?? '' }}" style="width:120px; padding:0.4rem;" />
                </div>

                <div class="form-group" style="margin-top:0.75rem;">
                    <label for="fase_tidur">Fase Tidur (opsional)</label>
                    <input type="text" id="fase_tidur" name="fase_tidur" value="{{ old('fase_tidur') ?? '' }}"
                        placeholder="contoh: ringan, dalam, REM" style="width:100%; padding:0.4rem;" />
                </div>

                <div style="margin-top:1rem;">
                    <button type="submit" class="btn btn-primary">Simpan Data Tidur</button>
                </div>
            </form>
        </div>

        <div style="margin-top:1.5rem;">
            <h3>Hasil Analisis Terakhir</h3>
            <div class="card" style="background:#f8f9fa; padding:1rem; border-radius:4px; margin-top:0.75rem;">
                @if(isset($hasil))
                    <p style="margin:0; font-size:1.1rem;">{{ $hasil }}</p>
                @else
                    <p style="margin:0; color:#666;">Belum ada data tidur.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        // small client-side guard to ensure number is provided
        document.getElementById('tidurForm').addEventListener('submit', function(e){
            const dur = parseFloat(document.getElementById('durasi_tidur').value);
            if (isNaN(dur) || dur <= 0) {
                e.preventDefault();
                alert('Masukkan durasi tidur dalam jam (mis. 7.5).');
                document.getElementById('durasi_tidur').focus();
            }
        });
    </script>
@endsection