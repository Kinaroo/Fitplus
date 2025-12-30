<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tantangan Olahraga - FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')

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
                @if(session('success'))
                    <div class="max-w-4xl mx-auto mb-6">
                        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-green-600"></i>
                                <p class="text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="max-w-4xl mx-auto mb-6">
                        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-exclamation-circle text-red-600"></i>
                                <p class="text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="max-w-4xl mx-auto">
                    <!-- Available Challenges Section -->
                    @if(isset($availableChallenges) && $availableChallenges->count() > 0)
                        <div class="mb-8">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-trophy text-yellow-500"></i>
                                Tantangan Tersedia
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($availableChallenges as $challenge)
                                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition">
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-trophy text-white text-lg"></i>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-gray-800">{{ $challenge->nama }}</h3>
                                                    <p class="text-sm text-gray-500">
                                                        Target: {{ number_format($challenge->target_value, 0) }} {{ $challenge->unit ?? '' }}
                                                    </p>
                                                </div>
                                            </div>
                                            @php
                                                $now = now()->format('Y-m-d');
                                                $status = 'active';
                                                if ($challenge->tanggal_mulai > $now) $status = 'upcoming';
                                            @endphp
                                            @if($status === 'upcoming')
                                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">Akan Datang</span>
                                            @else
                                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Aktif</span>
                                            @endif
                                        </div>
                                        
                                        @if($challenge->deskripsi)
                                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($challenge->deskripsi, 100) }}</p>
                                        @endif
                                        
                                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                            <span><i class="fas fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($challenge->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($challenge->tanggal_selesai)->format('d M Y') }}</span>
                                            <span><i class="fas fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($challenge->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($challenge->tanggal_selesai)) }} hari</span>
                                        </div>
                                        
                                        <form action="{{ route('tantangan.ikut', $challenge->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full py-2 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-lg hover:shadow-lg transition font-semibold">
                                                <i class="fas fa-plus mr-2"></i>Ikuti Tantangan
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Current Challenge Section -->
                    @if(isset($tantangan) && $tantangan)
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
                                        @elseif($tantangan->status === 'proses' || $tantangan->status === 'active')
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

                                <!-- Target Progress -->
                                @if($tantangan->target_value)
                                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
                                    <h3 class="text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-bullseye text-green-600 mr-2"></i>Progress Target
                                    </h3>
                                    <p class="text-2xl font-bold text-green-600">
                                        {{ number_format($tantangan->progress_value ?? 0, 1) }} / {{ number_format($tantangan->target_value, 0) }} {{ $tantangan->unit ?? '' }}
                                    </p>
                                    <div class="mt-3 w-full bg-gray-200 rounded-full h-3">
                                        @php
                                            $progress = $tantangan->target_value > 0 ? min(100, ($tantangan->progress_value / $tantangan->target_value) * 100) : 0;
                                        @endphp
                                        <div class="bg-gradient-to-r from-green-400 to-teal-500 h-3 rounded-full transition-all" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                                @else
                                <!-- Durasi -->
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
                                    <h3 class="text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-hourglass-half text-purple-600 mr-2"></i>Durasi Tantangan
                                    </h3>
                                    <p class="text-2xl font-bold text-purple-600">
                                        {{ \Carbon\Carbon::parse($tantangan->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($tantangan->tanggal_selesai)) }} hari
                                    </p>
                                </div>
                                @endif
                            </div>

                            <!-- Update Progress Form -->
                            @if($tantangan->target_value && !$selesai)
                            <div class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg p-6 border border-teal-200 mb-8">
                                <h3 class="text-sm font-semibold text-gray-700 mb-4">
                                    <i class="fas fa-plus-circle text-teal-600 mr-2"></i>Update Progress
                                </h3>
                                <form action="{{ route('tantangan.progress.add', $tantangan->id) }}" method="POST" class="flex gap-4">
                                    @csrf
                                    <input type="number" name="amount" step="0.1" min="0.1" placeholder="Jumlah {{ $tantangan->unit ?? '' }}" 
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-lg hover:shadow-lg transition font-semibold">
                                        <i class="fas fa-plus mr-2"></i>Tambah
                                    </button>
                                </form>
                            </div>
                            @endif

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
                                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
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
                                            <p class="text-green-700">Anda telah menyelesaikan tantangan ini!</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex gap-4 pt-6 border-t border-gray-200">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition font-semibold">
                                    <i class="fas fa-arrow-left"></i>Kembali
                                </a>
                            </div>
                        </div>
                    @elseif(!isset($availableChallenges) || $availableChallenges->count() === 0)
                        <!-- No Challenge Message -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-6 mb-8">
                            <div class="flex items-start gap-4">
                                <i class="fas fa-exclamation-circle text-yellow-600 text-xl mt-1"></i>
                                <div>
                                    <p class="text-yellow-800 font-semibold">Belum ada tantangan aktif</p>
                                    <p class="text-yellow-700 text-sm mt-2">Tunggu tantangan baru dari admin atau hubungi admin untuk membuat tantangan!</p>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State Card -->
                        <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200">
                            <i class="fas fa-trophy text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Tantangan</h3>
                            <p class="text-gray-600 mb-6">Tantangan akan muncul di sini ketika admin membuat tantangan baru.</p>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-lg hover:shadow-lg transition">
                                <i class="fas fa-arrow-left"></i>Kembali ke Dashboard
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
