@extends('layouts.admin')

@section('title', 'Admin - Edit Pengguna')
@section('page-title', 'Edit Pengguna')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Admin Nav -->
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-white text-gray-700 rounded-lg font-semibold border border-gray-300 hover:bg-gray-50 transition">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Pengguna
        </a>
        <a href="{{ route('admin.tantangan.index') }}" class="px-4 py-2 bg-white text-gray-700 rounded-lg font-semibold border border-gray-300 hover:bg-gray-50 transition">
            <i class="fas fa-trophy mr-2"></i>Tantangan
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-200">
            <div class="w-16 h-16 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                {{ strtoupper(substr($user->nama, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Edit Pengguna #{{ $user->id }}</h2>
                <p class="text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf 
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user text-teal-600 mr-2"></i>Nama
                    </label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-teal-600 mr-2"></i>Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="tinggi" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-ruler-vertical text-teal-600 mr-2"></i>Tinggi (cm)
                    </label>
                    <input type="number" id="tinggi" name="tinggi" value="{{ old('tinggi', $user->tinggi) }}" placeholder="e.g., 170"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="berat" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-weight text-teal-600 mr-2"></i>Berat (kg)
                    </label>
                    <input type="number" id="berat" name="berat" value="{{ old('berat', $user->berat) }}" placeholder="e.g., 65"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="is_admin" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user-shield text-teal-600 mr-2"></i>Role
                    </label>
                    <select id="is_admin" name="is_admin"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>User Biasa</option>
                        <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Administrator</option>
                    </select>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-teal-600 mr-2"></i>Password Baru
                    </label>
                    <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak diubah"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                </div>
            </div>
            
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
