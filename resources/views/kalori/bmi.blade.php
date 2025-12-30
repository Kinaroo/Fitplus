<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator BMI - FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-gradient-to-r from-teal-700 to-cyan-600 text-white px-8 py-4 flex justify-between items-center shadow-lg">
                <h1 class="text-2xl font-bold">Indeks Massa Tubuh</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-300">{{ auth()->user()->nama ?? 'User' }} • {{ now()->locale('id')->format('l, j F Y') }}</span>
                    <i class="fas fa-user-circle text-2xl"></i>
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-6xl mx-auto">
                    <!-- Calculator Card -->
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Form Section -->
                            <div class="lg:col-span-1">
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">Kalkulator BMI</h2>
                                <p class="text-gray-500 text-sm mb-6">Masukkan data Anda untuk menghitung indeks massa tubuh</p>

                                <form method="POST" action="{{ route('kalori.bmi.hitung') }}" class="space-y-5">
                                    @csrf
                                    
                                    <!-- Berat Badan -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-weight-scale mr-2 text-cyan-600"></i>Berat Badan (kg)
                                        </label>
                                        <input type="number" name="berat_badan" placeholder="Contoh: 70" 
                                            value="{{ old('berat_badan', $beratBadan ?? '') }}" step="0.1" min="20" max="300"
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100 transition"
                                            required>
                                        @error('berat_badan')
                                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Tinggi Badan -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-ruler-vertical mr-2 text-cyan-600"></i>Tinggi Badan (cm)
                                        </label>
                                        <input type="number" name="tinggi_badan" placeholder="Contoh: 170" 
                                            value="{{ old('tinggi_badan', $tinggiBadan ?? '') }}" step="1" min="100" max="250"
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100 transition"
                                            required>
                                        @error('tinggi_badan')
                                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Buttons -->
                                    <div class="flex gap-3 pt-4">
                                        <button type="submit" class="flex-1 bg-gradient-to-r from-cyan-500 to-teal-600 hover:from-cyan-600 hover:to-teal-700 text-white font-bold py-3 px-4 rounded-lg transition shadow-md hover:shadow-lg">
                                            <i class="fas fa-calculator mr-2"></i>Hitung
                                        </button>
                                        <a href="{{ route('kalori.bmi.reset') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                            <i class="fas fa-redo"></i>Reset
                                        </a>
                                    </div>
                                </form>

                                <!-- BMI Scale Info -->
                                <div class="mt-8 pt-8 border-t-2 border-gray-100">
                                    <p class="text-sm font-bold text-gray-700 mb-4">Kategori BMI</p>
                                    <div class="space-y-2 text-xs">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                            <span class="text-gray-600">Kurang (< 18.5)</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 bg-teal-500 rounded-full"></span>
                                            <span class="text-gray-600">Normal (18.5-24.9)</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                                            <span class="text-gray-600">Berlebih (25-29.9)</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                                            <span class="text-gray-600">Obesitas (≥ 30)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Result Section -->
                            <div class="lg:col-span-2">
                                @if ($bmi > 0)
                                    <!-- BMI Result Card -->
                                    <div class="bg-gradient-to-br {{ $warnaBg }} rounded-xl p-8 border-l-4 {{ $warnaBorder }} mb-6">
                                        <div class="text-center">
                                            <p class="text-gray-600 font-semibold mb-2 text-sm">INDEKS MASSA TUBUH</p>
                                            <p class="text-7xl font-bold {{ $warnaText }} mb-3">{{ $bmi }}</p>
                                            <span class="inline-block {{ $warnaBadge }} px-6 py-2 rounded-full font-bold text-lg">
                                                {{ $kategori }}
                                            </span>
                                            <p class="text-gray-600 mt-4 text-sm">Berat: {{ $beratBadan }} kg | Tinggi: {{ $tinggiBadan }} cm</p>
                                        </div>
                                    </div>

                                    <!-- Rekomendasi Card -->
                                    <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-blue-500 mb-6">
                                        <h4 class="font-bold text-blue-900 mb-3 text-lg">
                                            <i class="fas fa-lightbulb mr-2 text-blue-600"></i>Rekomendasi
                                        </h4>
                                        <p class="text-gray-800 text-sm leading-relaxed">{{ $rekomendasi }}</p>
                                    </div>

                                    <!-- Tips Kesehatan -->
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-base mb-4">Tips & Rekomendasi</h4>
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="bg-orange-50 rounded-lg p-4 border border-orange-200 text-center">
                                                <i class="fas fa-dumbbell text-orange-500 text-2xl mb-2"></i>
                                                <h5 class="font-bold text-gray-800 text-sm">Olahraga</h5>
                                                <p class="text-xs text-gray-600 mt-1">Lakukan olahraga minimal 150 menit per minggu untuk hidup lebih sehat.</p>
                                            </div>
                                            <div class="bg-green-50 rounded-lg p-4 border border-green-200 text-center">
                                                <i class="fas fa-leaf text-green-600 text-2xl mb-2"></i>
                                                <h5 class="font-bold text-gray-800 text-sm">Nutrisi</h5>
                                                <p class="text-xs text-gray-600 mt-1">Konsumsi makanan bergizi seimbang dengan porsi yang tepat.</p>
                                            </div>
                                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200 text-center">
                                                <i class="fas fa-moon text-blue-600 text-2xl mb-2"></i>
                                                <h5 class="font-bold text-gray-800 text-sm">Istirahat</h5>
                                                <p class="text-xs text-gray-600 mt-1">Tidur 7-9 jam setiap malam untuk menjaga kesehatan.</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Empty State -->
                                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-12 text-center border-2 border-dashed border-blue-200">
                                        <i class="fas fa-calculator text-6xl text-cyan-300 mb-4"></i>
                                        <p class="text-gray-600 text-lg font-semibold mb-2">Hitung BMI Anda</p>
                                        <p class="text-gray-500 text-sm">Masukkan berat badan dan tinggi badan untuk melihat hasil</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- BMI Scale Chart -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Skala BMI</h3>
                        <div class="flex gap-1 h-8 rounded-lg overflow-hidden shadow-md mb-4">
                            <div class="flex-1 bg-blue-500 flex items-center justify-center text-white text-xs font-bold">< 18.5</div>
                            <div class="flex-1 bg-teal-500 flex items-center justify-center text-white text-xs font-bold">18.5-24.9</div>
                            <div class="flex-1 bg-amber-500 flex items-center justify-center text-white text-xs font-bold">25-29.9</div>
                            <div class="flex-1 bg-red-500 flex items-center justify-center text-white text-xs font-bold">> 30</div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center text-xs">
                            <div>
                                <p class="font-bold text-blue-600">Kurang</p>
                                <p class="text-gray-600">Berat badan rendah</p>
                            </div>
                            <div>
                                <p class="font-bold text-teal-600">Normal</p>
                                <p class="text-gray-600">Berat badan ideal</p>
                            </div>
                            <div>
                                <p class="font-bold text-amber-600">Berlebih</p>
                                <p class="text-gray-600">Berat badan tinggi</p>
                            </div>
                            <div>
                                <p class="font-bold text-red-600">Obesitas</p>
                                <p class="text-gray-600">Berat badan sangat tinggi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>