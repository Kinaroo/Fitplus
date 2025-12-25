@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold mb-4">⚠️ Laporan Kesehatan Tidak Tersedia</h1>
            <p class="text-gray-600 text-lg">Halaman laporan kesehatan hanya dapat diakses jika Anda sudah login</p>
        </div>
        
        <div class="space-y-6">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded">
                <h2 class="font-bold text-blue-900 mb-3">Status Login:</h2>
                @if (auth()->check())
                    <p class="text-blue-800">✓ Anda sudah login sebagai <strong>{{ auth()->user()->nama }}</strong></p>
                    <p class="text-blue-600 mt-2 text-sm">Anda seharusnya bisa mengakses laporan kesehatan. Coba klik tombol di bawah.</p>
                @else
                    <p class="text-blue-800">✗ Anda BELUM LOGIN</p>
                    <p class="text-blue-600 mt-2 text-sm">Silakan login terlebih dahulu untuk mengakses laporan kesehatan</p>
                @endif
            </div>
            
            <div class="space-y-3">
                @if (auth()->check())
                    <a href="{{ route('laporan.kesehatan') }}" class="block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded text-center transition">
                        📊 Buka Laporan Kesehatan Sekarang
                    </a>
                    <a href="{{ route('dashboard') }}" class="block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded text-center transition">
                        🏠 Kembali ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login.form') }}" class="block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded text-center transition">
                        🔓 LOGIN
                    </a>
                    <p class="text-center text-gray-600">
                        Belum punya akun? <a href="{{ route('register.form') }}" class="text-blue-600 hover:underline">Daftar di sini</a>
                    </p>
                @endif
            </div>
            
            <hr class="my-6">
            
            <div class="bg-gray-50 p-6 rounded">
                <h3 class="font-bold text-gray-800 mb-3">💡 Cara Mengakses Laporan Kesehatan:</h3>
                <ol class="text-gray-700 space-y-2 list-decimal list-inside">
                    <li>Pastikan Anda sudah <strong>login</strong> ke akun FitPlus</li>
                    <li>Buka menu <strong>"Laporan Kesehatan"</strong> di sidebar</li>
                    <li>Halaman akan menampilkan laporan kesehatan komprehensif Anda</li>
                    <li>Anda dapat memilih periode laporan (7, 30, 90 hari, dll)</li>
                </ol>
            </div>
            
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded">
                <h3 class="font-bold text-yellow-900 mb-2">🔍 Debug Info:</h3>
                <p class="text-yellow-800 text-sm">
                    Session ID: <code class="bg-white px-2 py-1 rounded">{{ session()->getId() }}</code><br>
                    Authenticated: <strong>{{ auth()->check() ? 'YES' : 'NO' }}</strong><br>
                    User ID: <strong>{{ auth()->id() ?? '-' }}</strong>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
