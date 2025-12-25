@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-teal-500 text-white p-8">
                <h1 class="text-4xl font-bold">📊 Laporan Kesehatan</h1>
                <p class="text-green-100 mt-2">Pantau kesehatan Anda secara menyeluruh</p>
            </div>
            
            <!-- Content -->
            <div class="p-8 space-y-6">
                <!-- Status Check -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded">
                    <p class="text-lg font-bold text-blue-900 mb-2">✓ Status Anda:</p>
                    @if (auth()->check())
                        <p class="text-blue-800">Selamat datang, <strong>{{ auth()->user()->nama }}!</strong></p>
                        <p class="text-blue-600 text-sm mt-2">Anda sudah login dan dapat mengakses laporan kesehatan lengkap.</p>
                    @else
                        <p class="text-blue-800">Anda sedang tidak login</p>
                        <p class="text-blue-600 text-sm mt-2">Silakan login untuk mengakses laporan kesehatan.</p>
                    @endif
                </div>
                
                <!-- Main Action -->
                <div class="space-y-3">
                    @if (auth()->check())
                        <a href="{{ route('laporan.kesehatan') }}" class="flex items-center justify-center gap-3 bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-6 rounded-lg transition text-lg">
                            <i class="fas fa-chart-bar"></i>
                            Lihat Laporan Kesehatan Lengkap
                        </a>
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-3 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-6 rounded-lg transition">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login.form') }}" class="flex items-center justify-center gap-3 bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 px-6 rounded-lg transition text-lg">
                            <i class="fas fa-sign-in-alt"></i>
                            LOGIN
                        </a>
                        <p class="text-center text-gray-600">
                            Belum punya akun? <a href="{{ route('register.form') }}" class="text-blue-600 hover:underline font-semibold">Daftar sekarang</a>
                        </p>
                    @endif
                </div>
                
                <!-- Info Section -->
                @if (auth()->check())
                <hr class="my-6">
                
                <div class="bg-green-50 p-6 rounded">
                    <h3 class="font-bold text-green-900 mb-4">📈 Laporan Kesehatan Anda Mencakup:</h3>
                    <ul class="space-y-3 text-green-800">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-600 mt-1"></i>
                            <span><strong>Statistik Berat Badan</strong> - Trend berat badan Anda selama periode</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-600 mt-1"></i>
                            <span><strong>Analisis Tidur</strong> - Rata-rata durasi tidur dan kualitas istirahat</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-600 mt-1"></i>
                            <span><strong>Tracking Olahraga</strong> - Total aktivitas fisik dalam periode</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-600 mt-1"></i>
                            <span><strong>Analisis Nutrisi</strong> - Konsumsi kalori vs target harian</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-600 mt-1"></i>
                            <span><strong>Indeks Massa Tubuh (IMT)</strong> - Kategori kesehatan berdasarkan tinggi dan berat badan</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-600 mt-1"></i>
                            <span><strong>Rekomendasi Kesehatan</strong> - Saran personal berdasarkan data Anda</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-600 mt-1"></i>
                            <span><strong>Target Kesehatan</strong> - Progress terhadap goal kesehatan Anda</span>
                        </li>
                    </ul>
                </div>
                
                <div class="bg-purple-50 p-6 rounded">
                    <h3 class="font-bold text-purple-900 mb-3">⚙️ Fitur Tambahan:</h3>
                    <ul class="space-y-2 text-purple-800">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-filter text-purple-600"></i>
                            Filter laporan berdasarkan periode (7, 30, 90 hari, dll)
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-print text-purple-600"></i>
                            Download laporan kesehatan sebagai PDF
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-chart-line text-purple-600"></i>
                            Visualisasi data dalam bentuk grafik dan tabel
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
