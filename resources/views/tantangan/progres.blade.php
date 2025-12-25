<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tantangan - FitPlus</title>
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
                <a href="{{ route('makanan.harian') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-utensils text-lg text-red-300"></i>
                    <span>Pelacak Nutrisi</span>
                </a>
                <a href="{{ route('kalori.bmi') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-weight text-lg text-orange-300"></i>
                    <span>Indeks Massa Tubuh</span>
                </a>
                <a href="{{ route('tidur.analisis') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-moon text-lg text-indigo-300"></i>
                    <span>Pelacak Tidur</span>
                </a>
                <a href="{{ route('tantangan.progres') }}" class="flex items-center gap-3 bg-white bg-opacity-20 px-4 py-3 rounded-lg hover:bg-opacity-30 transition">
                    <i class="fas fa-flag text-lg text-purple-300"></i>
                    <span class="font-medium">Tantangan Olahraga</span>
                </a>
                <a href="{{ route('laporan.kesehatan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10 transition">
                    <i class="fas fa-chart-bar text-lg text-green-300"></i>
                    <span>Laporan Kesehatan</span>
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
                <h1 class="text-2xl font-bold">Tantangan Olahraga</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-300">{{ auth()->user()->nama ?? 'User' }} • {{ now()->locale('id')->format('l, j F Y') }}</span>
                    <i class="fas fa-user-circle text-2xl"></i>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-8">
                @if(isset($pesan))
                    <!-- No Challenge Message -->
                    <div class="max-w-4xl mx-auto">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-6 mb-8">
                            <div class="flex items-start gap-4">
                                <i class="fas fa-exclamation-circle text-yellow-600 text-xl mt-1"></i>
                                <div>
                                    <p class="text-yellow-800 font-semibold">{{ $pesan }}</p>
                                    <p class="text-yellow-700 text-sm mt-2">Mulai buat tantangan olahraga untuk memotivasi diri Anda dalam mencapai target kesehatan!</p>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State Card -->
                        <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200">
                            <i class="fas fa-trophy text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Tantangan Aktif</h3>
                            <p class="text-gray-600 mb-6">Buatlah tantangan olahraga baru untuk memulai perjalanan fitness Anda!</p>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-lg hover:shadow-lg transition">
                                <i class="fas fa-arrow-left"></i>Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Active Challenge Card -->
                    <div class="max-w-4xl mx-auto">
                        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 mb-8">
                            <!-- Header -->
                            <div class="mb-8 pb-6 border-b-2 border-purple-200">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center">
                                        <i class="fas fa-flag text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl font-bold text-gray-800">{{ $tantangan->nama_tantangan ?? 'Tantangan' }}</h2>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <i class="fas fa-calendar text-purple-600 mr-2"></i>
                                            {{ \Carbon\Carbon::parse($tantangan->tanggal_mulai)->locale('id')->format('d M Y') }} - 
                                            {{ \Carbon\Carbon::parse($tantangan->tanggal_selesai)->locale('id')->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Status -->
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
                                    <h3 class="text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>Status Tantangan
                                    </h3>
                                    <p class="text-2xl font-bold">
                                        @if($tantangan->status === 'belum')
                                            <span class="text-gray-600">
                                                <i class="fas fa-clock mr-2"></i>Belum Dimulai
                                            </span>
                                        @elseif($tantangan->status === 'proses')
                                            <span class="text-blue-600">
                                                <i class="fas fa-play-circle mr-2"></i>Sedang Berlangsung
                                            </span>
                                        @else
                                            <span class="text-green-600">
                                                <i class="fas fa-check-circle mr-2"></i>Selesai
                                            </span>
                                        @endif
                                    </p>
                                </div>

                                <!-- Durasi -->
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
                                    <h3 class="text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-timer text-purple-600 mr-2"></i>Durasi Tantangan
                                    </h3>
                                    <p class="text-2xl font-bold text-purple-600">
                                        {{ \Carbon\Carbon::parse($tantangan->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($tantangan->tanggal_selesai)) }} hari
                                    </p>
                                </div>
                            </div>

                            <!-- Kalori Hari Ini -->
                            <div class="bg-gradient-to-r from-orange-50 via-pink-50 to-red-50 rounded-lg p-8 border border-orange-200 mb-8">
                                <h3 class="text-sm font-semibold text-gray-700 mb-4">
                                    <i class="fas fa-fire text-orange-600 mr-2"></i>Kalori Terbakar Hari Ini
                                </h3>
                                <div class="flex items-end gap-4">
                                    <p class="text-4xl font-bold text-orange-600">{{ $kaloriHariIni ?? 0 }}</p>
                                    <p class="text-gray-600 mb-1">kkal</p>
                                </div>
                                <p class="text-sm text-gray-600 mt-4">
                                    <i class="fas fa-lightning text-yellow-500 mr-2"></i>
                                    Terus semangat! Lanjutkan aktivitas fisik Anda untuk mencapai target.
                                </p>
                            </div>

                            <!-- Success Message -->
                            @if($selesai)
                                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-6 mb-8">
                                    <div class="flex items-center gap-4">
                                        <i class="fas fa-star text-green-600 text-2xl"></i>
                                        <div>
                                            <p class="text-green-800 font-bold text-lg">🎉 Selamat!</p>
                                            <p class="text-green-700">Anda telah menyelesaikan tantangan hari ini! Reward menanti Anda.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="grid grid-cols-2 gap-4 pt-6 border-t border-gray-200">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-4 py-3 border-2 border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition font-semibold">
                                    <i class="fas fa-arrow-left"></i>Kembali
                                </a>
                                <button type="button" class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-lg hover:shadow-lg transition font-semibold">
                                    <i class="fas fa-plus"></i>Update Progress
                                </button>
                            </div>
                        </div>

                        <!-- Reward Section -->
                        @if($tantangan->reward)
                        <div class="bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl shadow-lg p-8 border border-yellow-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-gift text-yellow-600 mr-2"></i>Reward Tantangan
                            </h3>
                            <p class="text-gray-700 text-center text-lg font-semibold">{{ $tantangan->reward }}</p>
                        </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>