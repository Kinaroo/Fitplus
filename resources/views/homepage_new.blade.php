<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitPlus — Beranda</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-white text-gray-900">

{{-- Homepage - Halaman Utama FitPlus --}}

<!-- Header/Navbar -->
<nav class="bg-gradient-to-r from-white via-cyan-50 to-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-teal-400 to-green-400 flex items-center justify-center shadow-md">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <span class="text-2xl font-bold bg-gradient-to-r from-teal-600 to-green-600 bg-clip-text text-transparent">FitPlus</span>
        </div>
        <div>
            @auth
                <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-teal-500 to-green-500 text-white px-6 py-2 rounded-full hover:shadow-lg hover:from-teal-600 hover:to-green-600 transition font-semibold text-sm">Dashboard</a>
            @else
                <a href="{{ route('login.form') }}" class="bg-gradient-to-r from-teal-500 to-green-500 text-white px-6 py-2 rounded-full hover:shadow-lg hover:from-teal-600 hover:to-green-600 transition font-semibold text-sm">Masuk</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="bg-gradient-to-b from-cyan-50 via-white to-lime-50 py-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="mb-6 inline-block">
            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-100 to-green-100 px-4 py-2 rounded-full border border-teal-200">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                <span class="text-sm font-semibold text-teal-700">Platform Kesehatan #1 di Indonesia</span>
            </div>
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-4 leading-tight">
            Tingkatkan Kesehatan Anda dengan <span class="bg-gradient-to-r from-teal-600 to-green-600 bg-clip-text text-transparent">FitPlus</span>
        </h1>
        <p class="text-gray-700 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto mb-8">Platform kesehatan terpadu untuk memantau aktivitas harian, pola tidur, olahraga, nutrisi, dan berat badan Anda. Raih hidup sehat dari hari ini.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register.form') }}" class="inline-block bg-gradient-to-r from-teal-500 to-green-500 text-white px-8 py-3 rounded-full hover:shadow-lg hover:from-teal-600 hover:to-green-600 transition font-semibold">Mulai Gratis Sekarang</a>
            <a href="#fitur" class="inline-block bg-white text-teal-600 border-2 border-teal-600 px-8 py-3 rounded-full hover:bg-teal-50 transition font-semibold">Pelajari Selengkapnya</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="bg-white py-20" id="fitur">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan Kami</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Semua yang Anda butuhkan untuk perjalanan kesehatan yang sempurna dalam satu aplikasi</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Feature 1: Tracking Aktivitas -->
            <div class="group bg-gradient-to-br from-cyan-50 to-white rounded-xl border border-cyan-100 p-6 hover:shadow-xl hover:border-teal-300 transition duration-300">
                <div class="flex justify-center mb-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-teal-400 to-green-400 flex items-center justify-center shadow-md group-hover:shadow-lg transition">
                        <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm0-13c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5z"/></svg>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-teal-700 mb-2 text-center">Tracking Aktivitas</h3>
                <p class="text-gray-600 text-sm text-center">Pantau aktivitas harian Anda dengan detail lengkap dan analisis mendalam</p>
            </div>

            <!-- Feature 2: Monitor Tidur -->
            <div class="group bg-gradient-to-br from-cyan-50 to-white rounded-xl border border-cyan-100 p-6 hover:shadow-xl hover:border-teal-300 transition duration-300">
                <div class="flex justify-center mb-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-teal-400 to-green-400 flex items-center justify-center shadow-md group-hover:shadow-lg transition">
                        <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-teal-700 mb-2 text-center">Monitor Tidur</h3>
                <p class="text-gray-600 text-sm text-center">Catat dan analisis pola tidur untuk meningkatkan kualitas istirahat Anda</p>
            </div>

            <!-- Feature 3: Catatan Olahraga -->
            <div class="group bg-gradient-to-br from-cyan-50 to-white rounded-xl border border-cyan-100 p-6 hover:shadow-xl hover:border-teal-300 transition duration-300">
                <div class="flex justify-center mb-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-teal-400 to-green-400 flex items-center justify-center shadow-md group-hover:shadow-lg transition">
                        <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13.49 5.48c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm-3.6 13.9l1-4.4 2.1 2v6h2v-7.5l-2.1-2 .6-3c1.3 1.5 3.3 2.5 5.5 2.5v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1l-5.2 2.2v4.7h2v-3.4l3.6-1.6-.2 1 .2 4.6h2z"/></svg>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-teal-700 mb-2 text-center">Catatan Olahraga</h3>
                <p class="text-gray-600 text-sm text-center">Rekam semua aktivitas olahraga dengan jenis dan durasi yang presisi</p>
            </div>

            <!-- Feature 4: Analisis Progres -->
            <div class="group bg-gradient-to-br from-cyan-50 to-white rounded-xl border border-cyan-100 p-6 hover:shadow-xl hover:border-teal-300 transition duration-300">
                <div class="flex justify-center mb-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-teal-400 to-green-400 flex items-center justify-center shadow-md group-hover:shadow-lg transition">
                        <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18 9.41 12l4 4 6.3-6.29L20 12v-6z"/></svg>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-teal-700 mb-2 text-center">Analisis Progres</h3>
                <p class="text-gray-600 text-sm text-center">Lihat perkembangan kesehatan dengan grafik dan statistik komprehensif</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-gradient-to-r from-teal-600 via-green-600 to-cyan-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white mb-12">
            <h3 class="text-2xl font-bold mb-2">Dipercaya oleh Ribuan Pengguna</h3>
            <p class="text-teal-50">Bergabunglah dengan komunitas kesehatan terbesar di Indonesia</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center text-white">
            <!-- Stat 1 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-8 border border-white/20 hover:bg-white/20 transition">
                <div class="mb-4">
                    <svg class="w-12 h-12 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <p class="text-4xl font-bold mb-2">10,000+</p>
                <p class="text-teal-50">Pengguna Aktif</p>
            </div>

            <!-- Stat 2 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-8 border border-white/20 hover:bg-white/20 transition">
                <div class="mb-4">
                    <svg class="w-12 h-12 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18 9.41 12l4 4 6.3-6.29L20 12v-6z"/></svg>
                </div>
                <p class="text-4xl font-bold mb-2">50,000+</p>
                <p class="text-teal-50">Aktivitas Tercatat</p>
            </div>

            <!-- Stat 3 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-8 border border-white/20 hover:bg-white/20 transition">
                <div class="mb-4">
                    <svg class="w-12 h-12 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                </div>
                <p class="text-4xl font-bold mb-2">95%</p>
                <p class="text-teal-50">Kepuasan Pengguna</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-b from-white to-cyan-50 py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-teal-600 to-green-600 rounded-2xl p-12 text-center text-white shadow-2xl">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Mulai Perjalanan Kesehatan Anda Hari Ini</h2>
            <p class="text-teal-50 mb-8 text-lg">Bergabunglah dengan ribuan pengguna yang telah merasakan transformasi hidup sehat mereka. Gratis dan mudah untuk memulai!</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register.form') }}" class="inline-block bg-white text-teal-600 font-bold px-8 py-3 rounded-full hover:bg-teal-50 transition text-lg shadow-lg">
                    Daftar Gratis Sekarang
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-block bg-teal-500 text-white font-bold px-8 py-3 rounded-full hover:bg-teal-400 transition text-lg border-2 border-white">
                        Buka Dashboard
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-gray-400 py-12 border-t border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-teal-400 to-green-400 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    </div>
                    <span class="text-lg font-bold text-teal-400">FitPlus</span>
                </div>
                <p class="text-sm">Platform kesehatan terpadu untuk gaya hidup sehat Anda.</p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-teal-400 transition">Beranda</a></li>
                    <li><a href="#fitur" class="hover:text-teal-400 transition">Fitur</a></li>
                    <li><a href="{{ route('login.form') }}" class="hover:text-teal-400 transition">Masuk</a></li>
                    <li><a href="{{ route('register.form') }}" class="hover:text-teal-400 transition">Daftar</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Kontak</h4>
                <p class="text-sm mb-2">Email: support@fitplus.id</p>
                <p class="text-sm">Hubungi kami untuk bantuan atau pertanyaan</p>
            </div>
        </div>
        <div class="border-t border-gray-700 pt-8 text-center">
            <p class="text-xs">© 2025 FitPlus. Semua Hak Dilindungi. Platform kesehatan digital terbaik untuk Indonesia.</p>
        </div>
    </div>
</footer>

</body>
</html>
