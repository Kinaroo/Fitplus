<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Kesehatan - FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-teal-50 via-cyan-50 to-green-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-8 border border-teal-100">
            <!-- Header with Gradient -->
            <div class="flex items-center justify-between mb-8 pb-6 border-b-2 border-teal-100">
                <div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">Tambah Data</h1>
                    <p class="text-sm text-gray-600 mt-1">Catatan data kesehatan harian Anda</p>
                </div>
                <a href="{{ route('dashboard') }}" class="text-teal-400 hover:text-teal-600 transition transform hover:scale-110">
                    <i class="fas fa-times text-2xl"></i>
                </a>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('health-data.store') }}" class="space-y-5">
                @csrf

                <!-- Tanggal -->
                <div>
                    <label for="tanggal" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar text-teal-600 mr-2"></i>Tanggal
                    </label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 border-2 border-teal-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition bg-teal-50"
                        required>
                    @error('tanggal')
                        <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Umur -->
                <div>
                    <label for="umur" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-birthday-cake text-teal-600 mr-2"></i>Umur (tahun)
                    </label>
                    <input type="number" name="umur" id="umur" value="{{ old('umur') }}"
                        class="w-full px-4 py-2.5 border-2 border-teal-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition bg-teal-50"
                        placeholder="Masukkan umur Anda" min="1" max="120" required>
                    @error('umur')
                        <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Berat Badan -->
                <div>
                    <label for="berat_badan" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-weight text-cyan-600 mr-2"></i>Berat Badan (kg)
                    </label>
                    <input type="number" name="berat_badan" id="berat_badan" value="{{ old('berat_badan') }}"
                        class="w-full px-4 py-2.5 border-2 border-cyan-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition bg-cyan-50"
                        placeholder="Masukkan berat badan" step="0.1" min="20" max="300" required>
                    @error('berat_badan')
                        <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tinggi Badan -->
                <div>
                    <label for="tinggi_badan" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-ruler-vertical text-purple-600 mr-2"></i>Tinggi Badan (cm)
                    </label>
                    <input type="number" name="tinggi_badan" id="tinggi_badan" value="{{ old('tinggi_badan') }}"
                        class="w-full px-4 py-2.5 border-2 border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition bg-purple-50"
                        placeholder="Masukkan tinggi badan" step="0.1" min="100" max="250" required>
                    @error('tinggi_badan')
                        <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jam Tidur -->
                <div>
                    <label for="tidur" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-moon text-lime-600 mr-2"></i>Jam Tidur (jam)
                    </label>
                    <input type="number" name="tidur" id="tidur" value="{{ old('tidur') }}"
                        class="w-full px-4 py-2.5 border-2 border-lime-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition bg-lime-50"
                        placeholder="Masukkan jam tidur" step="0.5" min="0" max="24" required>
                    @error('tidur')
                        <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Olahraga -->
                <div>
                    <label for="olahraga" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-heartbeat text-green-600 mr-2"></i>Olahraga (menit)
                    </label>
                    <input type="number" name="olahraga" id="olahraga" value="{{ old('olahraga') }}"
                        class="w-full px-4 py-2.5 border-2 border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-green-50"
                        placeholder="Masukkan durasi olahraga" step="1" min="0" max="480" required>
                    @error('olahraga')
                        <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <!-- Alert Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mt-4">
                        <p class="text-red-800 text-sm font-medium">
                            <i class="fas fa-exclamation-circle mr-2"></i>Ada kesalahan pada form Anda
                        </p>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mt-4">
                        <p class="text-green-800 text-sm font-medium">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        </p>
                    </div>
                @endif

                <!-- Buttons -->
                <div class="grid grid-cols-2 gap-3 pt-6 mt-8 border-t-2 border-teal-100">
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2.5 border-2 border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition font-semibold text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="submit"
                        class="px-4 py-2.5 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-lg hover:shadow-lg hover:scale-105 transition font-semibold">
                        <i class="fas fa-plus mr-2"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
