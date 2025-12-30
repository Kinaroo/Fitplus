@extends('layouts.admin')

@section('title', 'Admin - Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Admin Nav -->
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-lg font-semibold shadow-md">
            <i class="fas fa-users mr-2"></i>Pengguna
        </a>
        <a href="{{ route('admin.tantangan.index') }}" class="px-4 py-2 bg-white text-gray-700 rounded-lg font-semibold border border-gray-300 hover:bg-gray-50 transition">
            <i class="fas fa-trophy mr-2"></i>Tantangan
        </a>
        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white text-gray-700 rounded-lg font-semibold border border-gray-300 hover:bg-gray-50 transition">
            <i class="fas fa-arrow-left mr-2"></i>Dashboard
        </a>
    </div>

    <!-- Stats Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Daftar Pengguna</h2>
                    <p class="text-gray-500">Total: {{ $users->total() }} pengguna terdaftar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Nama</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tinggi</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Berat</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Role</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $u)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $u->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-teal-400 to-cyan-400 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($u->nama, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $u->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $u->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $u->tinggi ? $u->tinggi . ' cm' : '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $u->berat ? $u->berat . ' kg' : '-' }}</td>
                        <td class="px-6 py-4">
                            @if($u->is_admin)
                                <span class="px-3 py-1 bg-gradient-to-r from-yellow-400 to-orange-400 text-white text-xs font-semibold rounded-full">Admin</span>
                            @else
                                <span class="px-3 py-1 bg-gray-200 text-gray-700 text-xs font-semibold rounded-full">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.edit', $u) }}" class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded-lg transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(auth()->id() !== $u->id)
                                <form method="POST" action="{{ route('admin.users.destroy', $u) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
                            <p>Belum ada pengguna terdaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
