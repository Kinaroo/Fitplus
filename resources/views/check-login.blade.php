@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl">
        <h1 class="text-3xl font-bold mb-6">🔍 Login Status Check</h1>
        
        <div class="space-y-4">
            @if (auth()->check())
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <p class="text-lg font-bold text-green-900">✓ Anda SUDAH LOGIN</p>
                    <p class="text-green-800 mt-2">
                        <strong>Nama:</strong> {{ auth()->user()->nama }}<br>
                        <strong>Email:</strong> {{ auth()->user()->email }}<br>
                        <strong>User ID:</strong> {{ auth()->user()->id }}
                    </p>
                </div>
                
                <div class="mt-6 space-y-3">
                    <p class="font-bold text-gray-700">Anda dapat mengakses:</p>
                    <a href="{{ route('laporan.kesehatan') }}" class="block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        👉 Klik di sini untuk membuka Laporan Kesehatan
                    </a>
                    <a href="{{ route('dashboard') }}" class="block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Kembali ke Dashboard
                    </a>
                </div>
            @else
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <p class="text-lg font-bold text-red-900">✗ Anda BELUM LOGIN</p>
                    <p class="text-red-800 mt-2">
                        Silakan login terlebih dahulu untuk mengakses Laporan Kesehatan.
                    </p>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('login.form') }}" class="block bg-blue-500 text-white px-4 py-2 rounded text-center hover:bg-blue-600">
                        Klik di sini untuk LOGIN
                    </a>
                </div>
            @endif
        </div>
        
        <hr class="my-8">
        
        <div class="bg-gray-50 p-4 rounded">
            <h2 class="font-bold mb-3">Debug Info:</h2>
            <p>Session ID: <code>{{ session()->getId() }}</code></p>
            <p>IP Address: <code>{{ request()->ip() }}</code></p>
            <p>User Agent: <code class="text-xs">{{ request()->userAgent() }}</code></p>
            <p>Is Secure: {{ request()->secure() ? 'Yes' : 'No' }}</p>
        </div>
    </div>
</div>
@endsection
