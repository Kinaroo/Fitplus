<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelacak Tidur - FitPlus</title>
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
                <h1 class="text-2xl font-bold">Pelacak Tidur</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-300">{{ auth()->user()->nama ?? 'User' }} • {{ now()->locale('id')->format('l, j F Y') }}</span>
                    <i class="fas fa-user-circle text-2xl"></i>
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-6xl mx-auto">
                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Durasi Tidur Hari Ini -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-semibold text-gray-700">Durasi Tidur Hari Ini</h3>
                                <i class="fas fa-bed text-indigo-500 text-2xl"></i>
                            </div>
                            <p class="text-3xl font-bold text-indigo-600">
                                @if($tidurHariIni)
                                    {{ number_format($tidurHariIni->durasi_jam, 1) }}
                                @else
                                    -
                                @endif
                            </p>
                            <p class="text-xs text-gray-600 mt-2">jam tidur</p>
                        </div>

                        <!-- Rata-rata Tidur -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-semibold text-gray-700">Rata-rata 7 Hari</h3>
                                <i class="fas fa-calendar text-blue-500 text-2xl"></i>
                            </div>
                            <p class="text-3xl font-bold text-blue-600">{{ number_format($rataRataTidur, 1) }}</p>
                            <p class="text-xs text-gray-600 mt-2">jam per malam</p>
                        </div>

                        <!-- Total Tidur Bulan Ini -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-semibold text-gray-700">Total Bulan Ini</h3>
                                <i class="fas fa-moon text-purple-500 text-2xl"></i>
                            </div>
                            <p class="text-3xl font-bold text-purple-600">{{ number_format($totalTidurBulanIni, 0) }}</p>
                            <p class="text-xs text-gray-600 mt-2">jam dalam sebulan</p>
                        </div>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    <!-- Input Tidur -->
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Catat Tidur Anda</h2>
                        
                        <form action="{{ route('tidur.simpan') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @csrf

                            <!-- Durasi Tidur -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-hourglass text-indigo-600 mr-2"></i>Durasi Tidur (jam)
                                </label>
                                <input type="number" name="durasi_tidur" placeholder="Contoh: 7.5" 
                                    value="{{ old('durasi_tidur') }}" step="0.25" min="0.25" max="24"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition"
                                    required>
                                @error('durasi_tidur')
                                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kualitas Tidur -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-star text-yellow-500 mr-2"></i>Kualitas Tidur (1-10)
                                </label>
                                <input type="number" name="kualitas_tidur" placeholder="Contoh: 8" 
                                    value="{{ old('kualitas_tidur') }}" step="1" min="1" max="10"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-100 transition">
                                @error('kualitas_tidur')
                                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fase Tidur -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-brain text-purple-600 mr-2"></i>Fase Tidur
                                </label>
                                <select name="fase_tidur" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition">
                                    <option value="">Pilih fase tidur</option>
                                    <option value="Ringan" {{ old('fase_tidur') == 'Ringan' ? 'selected' : '' }}>Tidur Ringan</option>
                                    <option value="Dalam" {{ old('fase_tidur') == 'Dalam' ? 'selected' : '' }}>Tidur Dalam</option>
                                    <option value="REM" {{ old('fase_tidur') == 'REM' ? 'selected' : '' }}>Tidur REM</option>
                                </select>
                                @error('fase_tidur')
                                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-3 flex gap-3">
                                <button type="submit" class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:shadow-lg text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
                                    <i class="fas fa-save"></i> Simpan Data Tidur
                                </button>
                                <button type="reset" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold transition">
                                    Reset
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Kategori Tidur -->
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h3 class="font-bold text-gray-800 text-base mb-4">Kategori Durasi Tidur</h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-4">
                                <div class="w-4 h-4 rounded-full bg-red-500"></div>
                                <span class="text-gray-700">Kurang Tidur (&lt; 6 jam)</span>
                                <span class="ml-auto text-gray-600 text-sm">Dapat mempengaruhi kesehatan</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-4 h-4 rounded-full bg-green-500"></div>
                                <span class="text-gray-700">Normal (6-8 jam)</span>
                                <span class="ml-auto text-gray-600 text-sm">Durasi tidur ideal untuk kesehatan</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-4 h-4 rounded-full bg-orange-500"></div>
                                <span class="text-gray-700">Berlebihan (&gt; 8 jam)</span>
                                <span class="ml-auto text-gray-600 text-sm">Mungkin ada masalah kesehatan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Analisis Tidur -->
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Analisis Tidur Hari Ini</h3>
                        @if($tidurHariIni)
                            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-6 border-l-4 border-indigo-500">
                                <h4 class="font-bold text-gray-800 mb-2">Status Tidur: <span class="text-indigo-600">{{ $hasil }}</span></h4>
                                <p class="text-gray-700 text-sm mb-4">
                                    @if($hasil == "Kurang tidur")
                                        Anda tidur kurang dari 6 jam. Cobalah untuk meningkatkan durasi tidur malam Anda menjadi minimal 6-8 jam untuk kesehatan optimal.
                                    @elseif($hasil == "Normal")
                                        Durasi tidur Anda sudah ideal (6-8 jam). Pertahankan kebiasaan tidur yang baik ini untuk kesehatan yang optimal.
                                    @else
                                        Durasi tidur Anda lebih dari 8 jam. Ini mungkin menandakan kelelahan atau masalah kesehatan lainnya. Coba konsultasi dengan dokter jika sering terjadi.
                                    @endif
                                </p>
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div class="bg-white p-4 rounded-lg">
                                        <p class="text-xs text-gray-600">Kualitas Tidur</p>
                                        <p class="text-xl font-bold text-gray-800">{{ $tidurHariIni->kualitas_tidur ?? '-' }}/10</p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg">
                                        <p class="text-xs text-gray-600">Fase Tidur</p>
                                        <p class="text-xl font-bold text-gray-800">{{ $tidurHariIni->fase_tidur ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-12 text-center border-2 border-dashed border-gray-300">
                                <i class="fas fa-bed text-6xl text-gray-300 mb-4"></i>
                                <p class="text-gray-600 text-lg font-semibold mb-2">Belum Ada Data Tidur Hari Ini</p>
                                <p class="text-gray-500 text-sm">Catat tidur Anda di atas untuk melihat analisis</p>
                            </div>
                        @endif
                    </div>

                    <!-- Riwayat Tidur -->
                    @if($riwayatTidur->count() > 0)
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Riwayat Tidur (7 Hari Terakhir)</h3>
                        <div class="space-y-3">
                            @foreach($riwayatTidur as $tidur)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center gap-4 flex-1">
                                    <i class="fas fa-calendar text-gray-400 text-xl"></i>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($tidur->tanggal)->locale('id')->format('l, j F Y') }}</p>
                                        <p class="text-xs text-gray-600">{{ $tidur->analisis() }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-indigo-600 text-lg">{{ $tidur->durasi_jam }}</p>
                                    <p class="text-xs text-gray-600">jam</p>
                                </div>
                                @if($tidur->kualitas_tidur)
                                <div class="text-right ml-4">
                                    <p class="font-bold text-yellow-500 text-lg">{{ $tidur->kualitas_tidur }}</p>
                                    <p class="text-xs text-gray-600">kualitas</p>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Tips Tidur Sehat -->
                    <div class="bg-white rounded-xl shadow-lg p-8 mt-8">
                        <h3 class="font-bold text-gray-800 text-lg mb-6">Tips & Rekomendasi Tidur Sehat</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-2">Jadwal Tidur Teratur</h4>
                                    <p class="text-sm text-gray-600">Tidur dan bangun pada waktu yang sama setiap hari membantu mengatur ritme sirkadian Anda.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white">
                                        <i class="fas fa-moon"></i>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-2">Lingkungan Tidur yang Baik</h4>
                                    <p class="text-sm text-gray-600">Pastikan kamar gelap, sejuk, dan tenang untuk kualitas tidur yang optimal.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-2">Hindari Gadget Sebelum Tidur</h4>
                                    <p class="text-sm text-gray-600">Cahaya biru dari layar dapat mengganggu produksi melatonin. Hindari 1-2 jam sebelum tidur.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                                        <i class="fas fa-coffee"></i>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-2">Batasi Kafein dan Alkohol</h4>
                                    <p class="text-sm text-gray-600">Hindari kafein 6 jam sebelum tidur dan alkohol yang dapat mengganggu kualitas tidur.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>