<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Makanan - FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-teal-600 to-cyan-500 text-white p-6 shadow-xl overflow-y-auto">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-teal-300 to-cyan-300 rounded-lg flex items-center justify-center font-bold text-teal-600 text-lg">
                    ❤️
                </div>
                <div>
                    <h2 class="text-xl font-bold">FitPlus</h2>
                    <p class="text-xs text-blue-100">{{ auth()->user()->nama ?? 'User' }}</p>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-chart-line text-lg"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-user-circle text-lg"></i>
                    <span>Profil</span>
                </a>
                <a href="{{ route('makanan.harian') }}" class="flex items-center gap-3 bg-white bg-opacity-20 px-4 py-3 rounded-lg hover:bg-opacity-30 transition">
                    <i class="fas fa-utensils text-lg text-red-300"></i>
                    <span>Pelacak Nutrisi</span>
                </a>
            </nav>

            <div class="mt-auto pt-6 border-t border-blue-400">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-500 hover:bg-opacity-20 transition text-red-200 font-medium">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-gradient-to-r from-teal-700 to-cyan-600 text-white px-8 py-4 flex justify-between items-center shadow-lg">
                <h1 class="text-2xl font-bold">Tambah Makanan</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-300">{{ auth()->user()->nama ?? 'User' }} • {{ now()->locale('id')->format('l, j F Y') }}</span>
                    <i class="fas fa-user-circle text-2xl"></i>
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-3xl mx-auto">
                    <!-- Form Tambah Makanan -->
                    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Pilih Makanan</h2>
                        
                        @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                            <p class="text-red-800 text-sm font-medium">
                                <i class="fas fa-exclamation-circle mr-2"></i>Ada kesalahan pada form Anda
                            </p>
                        </div>
                        @endif

                        @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6">
                            <p class="text-green-800 text-sm font-medium">
                                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            </p>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('makanan.tambah') }}" class="space-y-6">
                            @csrf

                            <!-- Search Makanan -->
                            <div>
                                <label for="makanan_id" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-search text-teal-600 mr-2"></i>Cari Makanan
                                </label>
                                <div class="relative">
                                    <input type="text" id="searchMakanan" placeholder="Ketik nama makanan..." 
                                        class="w-full px-4 py-3 border-2 border-teal-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition bg-teal-50"
                                        autocomplete="off">
                                    <div id="makananList" class="absolute top-full left-0 right-0 bg-white border-2 border-teal-200 rounded-lg mt-1 shadow-lg z-10 max-h-64 overflow-y-auto hidden">
                                    </div>
                                </div>
                                <input type="hidden" name="makanan_id" id="makanan_id" value="{{ old('makanan_id') }}" required>
                                @error('makanan_id')
                                <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Makanan Terpilih -->
                            <div id="makananTerpilih" class="hidden bg-gradient-to-br from-teal-50 to-cyan-50 rounded-lg p-6 border-2 border-teal-200">
                                <h3 class="font-bold text-gray-800 mb-4" id="namaMakanan"></h3>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-600">Kalori</p>
                                        <p class="text-lg font-bold text-orange-600" id="kaloriMakanan">0</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Protein</p>
                                        <p class="text-lg font-bold text-red-600" id="proteinMakanan">0g</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Karbohidrat</p>
                                        <p class="text-lg font-bold text-yellow-600" id="karboMakanan">0g</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Lemak</p>
                                        <p class="text-lg font-bold text-purple-600" id="lemakMakanan">0g</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Porsi -->
                            <div>
                                <label for="porsi" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-bowl-rice text-cyan-600 mr-2"></i>Jumlah Porsi
                                </label>
                                <div class="flex items-center gap-4">
                                    <button type="button" onclick="decreasePortsi()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="porsi" id="porsi" value="{{ old('porsi', 1) }}" min="1" max="10"
                                        class="w-24 px-4 py-3 border-2 border-cyan-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition bg-cyan-50 text-center font-bold text-lg"
                                        required>
                                    <button type="button" onclick="increasePortsi()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                @error('porsi')
                                <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-3 pt-6 border-t-2 border-gray-200">
                                <a href="{{ route('makanan.harian') }}"
                                    class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition font-semibold text-center">
                                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                                </a>
                                <button type="submit"
                                    class="flex-1 px-4 py-3 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-lg hover:shadow-lg hover:scale-105 transition font-semibold">
                                    <i class="fas fa-plus mr-2"></i>Tambah Makanan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Daftar Makanan Populer -->
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Makanan Populer</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($makanan as $item)
                            <button type="button" onclick="selectMakanan({{ $item->id }}, '{{ $item->nama_makanan }}', {{ $item->kalori }}, {{ $item->protein }}, {{ $item->karbohidrat }}, {{ $item->lemak }})"
                                class="text-left bg-gradient-to-br from-gray-50 to-gray-100 hover:from-teal-50 hover:to-cyan-50 rounded-lg p-4 border-2 border-gray-200 hover:border-teal-400 transition">
                                <h3 class="font-semibold text-gray-800">{{ $item->nama_makanan }}</h3>
                                <p class="text-sm text-gray-600 mt-2">
                                    <i class="fas fa-fire text-orange-500 mr-1"></i>{{ $item->kalori }} kkal
                                </p>
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let makananData = {
            id: null,
            nama: '',
            kalori: 0,
            protein: 0,
            karbohidrat: 0,
            lemak: 0
        };

        // Search makanan
        document.getElementById('searchMakanan').addEventListener('input', function(e) {
            const query = e.target.value;
            const listEl = document.getElementById('makananList');

            if (query.length < 2) {
                listEl.classList.add('hidden');
                return;
            }

            fetch(`{{ route('makanan.search') }}?q=${query}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        listEl.innerHTML = '<div class="p-4 text-gray-500">Tidak ada makanan ditemukan</div>';
                    } else {
                        listEl.innerHTML = data.map(item => `
                            <button type="button" class="w-full text-left px-4 py-3 hover:bg-teal-50 border-b border-gray-100 transition"
                                onclick="selectMakanan(${item.id}, '${item.nama_makanan}', ${item.kalori || 0}, 0, 0, 0)">
                                <div class="font-semibold text-gray-800">${item.nama_makanan}</div>
                                <div class="text-sm text-gray-600"><i class="fas fa-fire text-orange-500 mr-1"></i>${item.kalori || 0} kkal</div>
                            </button>
                        `).join('');
                    }
                    listEl.classList.remove('hidden');
                })
                .catch(err => console.error(err));
        });

        function selectMakanan(id, nama, kalori, protein, karbohidrat, lemak) {
            makananData = { id, nama, kalori, protein, karbohidrat, lemak };
            document.getElementById('makanan_id').value = id;
            document.getElementById('searchMakanan').value = nama;
            document.getElementById('makananList').classList.add('hidden');

            // Show selected makanan info
            document.getElementById('namaMakanan').textContent = nama;
            document.getElementById('kaloriMakanan').textContent = kalori;
            document.getElementById('proteinMakanan').textContent = protein + 'g';
            document.getElementById('karboMakanan').textContent = karbohidrat + 'g';
            document.getElementById('lemakMakanan').textContent = lemak + 'g';
            document.getElementById('makananTerpilih').classList.remove('hidden');

            updateNutrition();
        }

        function increasePortsi() {
            const porsiEl = document.getElementById('porsi');
            if (porsiEl.value < 10) porsiEl.value = parseInt(porsiEl.value) + 1;
            updateNutrition();
        }

        function decreasePortsi() {
            const porsiEl = document.getElementById('porsi');
            if (porsiEl.value > 1) porsiEl.value = parseInt(porsiEl.value) - 1;
            updateNutrition();
        }

        function updateNutrition() {
            const porsi = parseInt(document.getElementById('porsi').value) || 1;
            document.getElementById('kaloriMakanan').textContent = makananData.kalori * porsi;
            document.getElementById('proteinMakanan').textContent = (makananData.protein * porsi).toFixed(1) + 'g';
            document.getElementById('karboMakanan').textContent = (makananData.karbohidrat * porsi).toFixed(1) + 'g';
            document.getElementById('lemakMakanan').textContent = (makananData.lemak * porsi).toFixed(1) + 'g';
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id !== 'searchMakanan') {
                document.getElementById('makananList').classList.add('hidden');
            }
        });
    </script>
</body>
</html>
