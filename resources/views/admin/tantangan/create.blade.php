@extends('layouts.admin')

@section('title', 'Admin - Buat Tantangan')
@section('page-title', 'Buat Tantangan Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Admin Nav -->
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('admin.tantangan.index') }}" class="px-4 py-2 bg-white text-gray-700 rounded-lg font-semibold border border-gray-300 hover:bg-gray-50 transition">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Tantangan
        </a>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-white text-gray-700 rounded-lg font-semibold border border-gray-300 hover:bg-gray-50 transition">
            <i class="fas fa-users mr-2"></i>Pengguna
        </a>
    </div>

    <!-- Create Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-200">
            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                <i class="fas fa-trophy text-white text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Buat Tantangan Baru</h2>
                <p class="text-gray-500">Buat tantangan olahraga untuk pengguna</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.tantangan.store') }}">
            @csrf
            
            <div class="mb-6">
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-flag text-teal-600 mr-2"></i>Nama Tantangan <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                    placeholder="e.g., 30 Hari Lari Pagi"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            
            <div class="mb-6">
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-align-left text-teal-600 mr-2"></i>Deskripsi
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="3" 
                    placeholder="Jelaskan tantangan ini..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">{{ old('deskripsi') }}</textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="target_value" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-bullseye text-teal-600 mr-2"></i>Target <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="target_value" name="target_value" step="0.01" value="{{ old('target_value') }}" required
                        placeholder="e.g., 100"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="unit" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-ruler text-teal-600 mr-2"></i>Satuan
                    </label>
                    <input type="text" id="unit" name="unit" value="{{ old('unit') }}"
                        placeholder="e.g., km, menit, langkah"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt text-teal-600 mr-2"></i>Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-check text-teal-600 mr-2"></i>Tanggal Selesai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', date('Y-m-d', strtotime('+30 days'))) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
            </div>
            
            <div class="mb-6 p-4 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border border-teal-200">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" id="assign_all" name="assign_all" value="1" 
                        class="w-5 h-5 text-teal-600 rounded focus:ring-teal-500">
                    <div>
                        <span class="font-semibold text-gray-800">Ikutkan semua pengguna</span>
                        <p class="text-sm text-gray-600">Otomatis mendaftarkan semua pengguna yang ada ke tantangan ini</p>
                    </div>
                </label>
            </div>
            
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg font-semibold hover:shadow-lg transition">
                    <i class="fas fa-trophy mr-2"></i>Buat Tantangan
                </button>
                <a href="{{ route('admin.tantangan.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
