@extends('layouts.app')

@section('title', 'Tambah Makanan - FitPlus')

@section('content')
    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2>Tambah Makanan</h2>

        <form action="{{ route('makanan.tambah') }}" method="POST">
            @csrf

            <div class="form-group" style="position: relative;">
                <label for="makanan_search">Pilih Makanan</label>

                <!-- Visible typed input for live search -->
                <input type="text" id="makanan_search" name="makanan_search" autocomplete="off"
                    placeholder="Ketik nama makanan..." required
                    style="width:100%; padding:0.5rem; box-sizing:border-box;" />

                <!-- Hidden input actually submitted -->
                <input type="hidden" id="makanan_id" name="makanan_id" value="" />

                <!-- Autocomplete suggestions -->
                <ul id="makanan_suggestions"
                    style="list-style:none; margin:0; padding:0; position:absolute; z-index:1000; background:white; width:100%; border:1px solid #ccc; max-height:240px; overflow:auto; display:none;">
                    <!-- suggestions injected here -->
                </ul>

                @error('makanan_id') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div id="gizi-info"
                style="display: none; background: #f0f0f0; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                <p><strong>Gizi per Porsi:</strong></p>
                <p>Kalori: <span id="kalori-per-porsi">0</span> kkal</p>
            </div>

            <div class="form-group">
                <label for="porsi">Jumlah Porsi</label>
                <input type="number" id="porsi" name="porsi" value="1" min="1" max="10" required
                    onchange="updateGizi(document.getElementById('makanan_id').value)">
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
        // Debounce helper
        function debounce(fn, wait) {
            let t;
            return function (...args) {
                clearTimeout(t);
                t = setTimeout(() => fn.apply(this, args), wait);
            };
        }

        const searchInput = document.getElementById('makanan_search');
        const hiddenId = document.getElementById('makanan_id');
        const suggestionsEl = document.getElementById('makanan_suggestions');
        const porsiInput = document.getElementById('porsi');
        const kaloriPerPorsiEl = document.getElementById('kalori-per-porsi');
        const totalKaloriEl = document.getElementById('total-kalori');

        let activeIndex = -1;
        let currentResults = [];

        function renderSuggestions(results) {
            currentResults = results;
            suggestionsEl.innerHTML = '';
            activeIndex = -1;

            if (!results.length) {
                suggestionsEl.style.display = 'none';
                return;
            }

            for (let i = 0; i < results.length; i++) {
                const r = results[i];
                const li = document.createElement('li');
                li.setAttribute('data-id', r.id);
                li.setAttribute('data-kalori', r.kalori);
                li.setAttribute('data-name', r.nama_makanan);
                li.style.padding = '0.5rem';
                li.style.cursor = 'pointer';
                li.textContent = `${r.nama_makanan} — ${Math.round(r.kalori)} kkal`;

                li.addEventListener('click', function () {
                    selectSuggestion(i);
                });

                suggestionsEl.appendChild(li);
            }
            suggestionsEl.style.display = 'block';
        }

        function selectSuggestion(index) {
            const r = currentResults[index];
            if (!r) return;

            // set visible text and hidden id + store kalori on hidden input
            searchInput.value = r.nama_makanan;
            hiddenId.value = r.id;
            hiddenId.dataset.kalori = r.kalori;

            // update gizi display
            const porsi = parseFloat(porsiInput.value || 1);
            kaloriPerPorsiEl.textContent = Math.round(r.kalori);
            totalKaloriEl.textContent = Math.round(r.kalori * porsi);

            // hide suggestions
            suggestionsEl.style.display = 'none';
        }

        async function doSearch(q) {
            if (!q || q.trim().length < 1) {
                renderSuggestions([]);
                hiddenId.value = '';
                return;
            }

            try {
                const res = await fetch(`{{ route('makanan.search') }}?q=` + encodeURIComponent(q), {
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!res.ok) {
                    console.error('Search request failed', res.status);
                    renderSuggestions([]);
                    return;
                }
                const data = await res.json();
                renderSuggestions(data);
            } catch (err) {
                console.error('Search error', err);
                renderSuggestions([]);
            }
        }

        const debouncedSearch = debounce(function () {
            // clear selected makanan_id when user types new query
            hiddenId.value = '';
            hiddenId.removeAttribute('data-kalori');
            doSearch(searchInput.value);
        }, 250);

        searchInput.addEventListener('input', debouncedSearch);

        // keyboard navigation
        searchInput.addEventListener('keydown', function (e) {
            const items = suggestionsEl.querySelectorAll('li');
            if (!items.length) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = Math.min(activeIndex + 1, items.length - 1);
                updateActive(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = Math.max(activeIndex - 1, 0);
                updateActive(items);
            } else if (e.key === 'Enter') {
                if (activeIndex >= 0 && activeIndex < items.length) {
                    e.preventDefault();
                    selectSuggestion(activeIndex);
                }
            } else if (e.key === 'Escape') {
                suggestionsEl.style.display = 'none';
            }
        });

        function updateActive(items) {
            items.forEach((it, idx) => {
                if (idx === activeIndex) {
                    it.style.background = '#eef';
                } else {
                    it.style.background = '';
                }
            });
        }

        // Close suggestions when clicking outside
        document.addEventListener('click', function (e) {
            if (!suggestionsEl.contains(e.target) && e.target !== searchInput) {
                suggestionsEl.style.display = 'none';
            }
        });

        // updateGizi function used when porsi changes or when user picks food
        function updateGiziFromSelected() {
            const kalori = parseFloat(hiddenId.dataset.kalori || 0);
            const porsi = parseFloat(porsiInput.value || 1);
            if (kalori && porsi) {
                kaloriPerPorsiEl.textContent = Math.round(kalori);
                totalKaloriEl.textContent = Math.round(kalori * porsi);
            } else {
                kaloriPerPorsiEl.textContent = 0;
                totalKaloriEl.textContent = 0;
            }
        }

        porsiInput.addEventListener('change', function () {
            updateGiziFromSelected();
        });

        // If user focuses the search input and there are current results, show them
        searchInput.addEventListener('focus', function () {
            if (currentResults.length) {
                suggestionsEl.style.display = 'block';
            }
        });
    </script>
@endsection