@extends('layouts.admin')

@section('title', 'Admin - Kelola Tantangan')
@section('page-title', 'Kelola Tantangan')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Admin Nav -->
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-white text-gray-700 rounded-lg font-semibold border border-gray-300 hover:bg-gray-50 transition">
            <i class="fas fa-users mr-2"></i>Pengguna
        </a>
        <a href="{{ route('admin.tantangan.index') }}" class="px-4 py-2 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-lg font-semibold shadow-md">
            <i class="fas fa-trophy mr-2"></i>Tantangan
        </a>
        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white text-gray-700 rounded-lg font-semibold border border-gray-300 hover:bg-gray-50 transition">
            <i class="fas fa-arrow-left mr-2"></i>Dashboard
        </a>
    </div>

    <!-- Stats Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border border-gray-200">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-trophy text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Daftar Tantangan</h2>
                    <p class="text-gray-500">Kelola tantangan untuk semua pengguna</p>
                </div>
            </div>
            <a href="{{ route('admin.tantangan.create') }}" class="px-5 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg font-semibold hover:shadow-lg transition">
                <i class="fas fa-plus mr-2"></i>Buat Tantangan
            </a>
        </div>
    </div>

    <!-- Challenges Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Nama Tantangan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Target</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Mulai</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Selesai</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($tantangan as $t)
                    @php
                        $now = now()->format('Y-m-d');
                        $status = 'active';
                        if ($t->tanggal_mulai > $now) $status = 'upcoming';
                        elseif ($t->tanggal_selesai < $now) $status = 'expired';
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $t->id }}</td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $t->nama }}</p>
                                @if($t->deskripsi)
                                    <p class="text-xs text-gray-500 mt-1">{{ Str::limit($t->deskripsi, 50) }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="font-semibold text-teal-600">{{ number_format($t->target_value, 0) }}</span> {{ $t->unit ?? '' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($t->tanggal_mulai)->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($t->tanggal_selesai)->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @if($status === 'active')
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                    <i class="fas fa-play-circle mr-1"></i>Aktif
                                </span>
                            @elseif($status === 'upcoming')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                    <i class="fas fa-clock mr-1"></i>Akan Datang
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-200 text-gray-600 text-xs font-semibold rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i>Selesai
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.tantangan.edit', $t->id) }}" class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded-lg transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.tantangan.destroy', $t->id) }}" style="display:inline;" onsubmit="return confirm('Hapus tantangan ini dan semua progress user?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-trophy text-4xl text-gray-300 mb-3"></i>
                            <p>Belum ada tantangan</p>
                            <a href="{{ route('admin.tantangan.create') }}" class="inline-block mt-3 text-teal-600 hover:underline">
                                <i class="fas fa-plus mr-1"></i>Buat tantangan pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
