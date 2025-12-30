@extends('layouts.admin')

@section('title', 'Admin - Edit Tantangan')
@section('page-title', 'Edit Tantangan')

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

    <!-- Edit Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-200">
            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                <i class="fas fa-edit text-white text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Edit Tantangan #{{ $tantangan->id }}</h2>
                <p class="text-gray-500">{{ $tantangan->nama }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.tantangan.update', $tantangan) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-flag text-teal-600 mr-2"></i>Nama Tantangan <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $tantangan->nama) }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            
            <div class="mb-6">
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-align-left text-teal-600 mr-2"></i>Deskripsi
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">{{ old('deskripsi', $tantangan->deskripsi) }}</textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="target_value" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-bullseye text-teal-600 mr-2"></i>Target <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="target_value" name="target_value" step="0.01" value="{{ old('target_value', $tantangan->target_value) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="unit" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-ruler text-teal-600 mr-2"></i>Satuan
                    </label>
                    <input type="text" id="unit" name="unit" value="{{ old('unit', $tantangan->unit) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt text-teal-600 mr-2"></i>Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $tantangan->tanggal_mulai) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-check text-teal-600 mr-2"></i>Tanggal Selesai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $tantangan->tanggal_selesai) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
            </div>
            
            <div class="mb-6 p-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border border-yellow-300">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" id="propagate" name="propagate" value="1" 
                        class="w-5 h-5 text-yellow-600 rounded focus:ring-yellow-500">
                    <div>
                        <span class="font-semibold text-gray-800"><i class="fas fa-exclamation-triangle text-yellow-600 mr-1"></i>Update semua peserta</span>
                        <p class="text-sm text-gray-600">Perbarui target, satuan, dan tanggal untuk semua pengguna yang mengikuti tantangan ini</p>
                    </div>
                </label>
            </div>
            
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('admin.tantangan.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
