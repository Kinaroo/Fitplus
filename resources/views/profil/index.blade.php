<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - FitPlus</title>
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
                <h1 class="text-2xl font-bold">Profil</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-300">{{ auth()->user()->nama ?? 'User' }} • {{ now()->locale('id')->format('l, j F Y') }}</span>
                    <i class="fas fa-user-circle text-2xl"></i>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-2xl mx-auto">
                    <!-- Card -->
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
                        <div class="mb-8 pb-6 border-b-2 border-teal-200">
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                                <i class="fas fa-user-circle text-teal-600 mr-3"></i>Data Profil Saya
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Kelola informasi profil dan data kesehatan Anda</p>
                        </div>

                        <form action="{{ route('profil.update') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Nama (Disabled) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user text-teal-600 mr-2"></i>Nama
                                </label>
                                <input type="text" value="{{ auth()->user()->nama }}" disabled 
                                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                            </div>

                            <!-- Email (Disabled) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-envelope text-cyan-600 mr-2"></i>Email
                                </label>
                                <input type="email" value="{{ auth()->user()->email }}" disabled 
                                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                            </div>

                            <!-- Jenis Kelamin (Disabled) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-venus-mars text-purple-600 mr-2"></i>Jenis Kelamin
                                </label>
                                <input type="text" value="{{ auth()->user()->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}" disabled 
                                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                            </div>

                            <!-- Tinggi Badan -->
                            <div>
                                <label for="tinggi" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-ruler-vertical text-orange-600 mr-2"></i>Tinggi Badan (cm)
                                </label>
                                <input type="number" id="tinggi" name="tinggi" 
                                    value="{{ auth()->user()->tinggi ?? '' }}" 
                                    min="100" max="250" step="0.1" required
                                    class="w-full px-4 py-2.5 border-2 border-teal-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-teal-50"
                                    placeholder="Masukkan tinggi badan Anda">
                                @error('tinggi')
                                    <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Berat Badan -->
                            <div>
                                <label for="berat" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-weight text-cyan-600 mr-2"></i>Berat Badan (kg)
                                </label>
                                <input type="number" id="berat" name="berat" 
                                    value="{{ auth()->user()->berat ?? '' }}" 
                                    min="20" max="300" step="0.1" required
                                    class="w-full px-4 py-2.5 border-2 border-cyan-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-cyan-50"
                                    placeholder="Masukkan berat badan Anda">
                                @error('berat')
                                    <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Alert Messages -->
                            @if ($errors->any())
                                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                                    <p class="text-red-800 text-sm font-medium">
                                        <i class="fas fa-exclamation-circle mr-2"></i>Ada kesalahan pada form Anda
                                    </p>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
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
                                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>