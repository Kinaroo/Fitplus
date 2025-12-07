@extends('layouts.app')

@section('title', 'Tambah Makanan - FitPlus')

@section('content')
    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2>Tambah Makanan</h2>
        
        <form action="{{ route('makanan.tambah') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="makanan_id">Pilih Makanan</label>
                <select id="makanan_id" name="makanan_id" required onchange="updateGizi(this.value)">
                    <option value="">-- Pilih Makanan --</option>
                    @foreach($makanan as $item)
                        <option value="{{ $item->id }}" data-kalori="{{ $item->kalori }}">
                            {{ $item->nama_makanan }}
                        </option>
                    @endforeach
                </select>
                @error('makanan_id') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div id="gizi-info" style="display: none; background: #f0f0f0; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                <p><strong>Gizi per Porsi:</strong></p>
                <p>Kalori: <span id="kalori-per-porsi">0</span> kkal</p>
            </div>

            <div class="form-group">
                <label for="porsi">Jumlah Porsi</label>
                <input type="number" id="porsi" name="porsi" value="1" min="1" max="10" required onchange="updateGizi(document.getElementById('makanan_id').value)">
                @error('porsi') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div id="total-gizi" style="background: #e8f4f8; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                <p><strong>Total Kalori:</strong> <span id="total-kalori">0</span> kkal</p>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Makanan</button>
        </form>
    </div>

    <script>
        function updateGizi(makananId) {
            const porsi = document.getElementById('porsi').value || 1;
            const select = document.querySelector(`option[value="${makananId}"]`);
            
            if (select && select.dataset.kalori) {
                const kaloriPerPorsi = parseFloat(select.dataset.kalori);
                const totalKalori = kaloriPerPorsi * porsi;
                
                document.getElementById('kalori-per-porsi').textContent = kaloriPerPorsi.toFixed(0);
                document.getElementById('total-kalori').textContent = totalKalori.toFixed(0);
                document.getElementById('gizi-info').style.display = 'block';
            } else {
                document.getElementById('gizi-info').style.display = 'none';
            }
        }
    </script>
@endsection