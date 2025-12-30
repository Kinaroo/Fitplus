<!-- Sidebar -->
<div class="w-64 bg-gradient-to-b from-teal-600 to-cyan-500 text-white p-6 shadow-xl overflow-y-auto flex-shrink-0">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 bg-gradient-to-br from-teal-300 to-cyan-300 rounded-lg flex items-center justify-center font-bold text-teal-600 text-lg">
            ❤️
        </div>
        <div>
            <h2 class="text-xl font-bold">FitPlus</h2>
            <p class="text-xs text-blue-100">{{ auth()->user()->nama ?? 'User' }}</p>
        </div>
    </div>

    <nav class="space-y-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition">
            <i class="fas fa-chart-line text-lg"></i>
            <span class="{{ request()->routeIs('dashboard') ? 'font-medium' : '' }}">Dashboard</span>
        </a>
        <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('profil') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition">
            <i class="fas fa-user-circle text-lg"></i>
            <span class="{{ request()->routeIs('profil') ? 'font-medium' : '' }}">Profil</span>
        </a>
        <a href="{{ route('health-data.form') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('health-data.*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition">
            <i class="fas fa-plus-circle text-lg text-green-300"></i>
            <span class="{{ request()->routeIs('health-data.*') ? 'font-medium' : '' }}">Tambah Data Harian</span>
        </a>
        <a href="{{ route('makanan.harian') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('makanan.*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition">
            <i class="fas fa-utensils text-lg text-red-300"></i>
            <span class="{{ request()->routeIs('makanan.*') ? 'font-medium' : '' }}">Pelacak Nutrisi</span>
        </a>
        <a href="{{ route('kalori.bmi') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('kalori.bmi*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition">
            <i class="fas fa-weight text-lg text-orange-300"></i>
            <span class="{{ request()->routeIs('kalori.bmi*') ? 'font-medium' : '' }}">Indeks Massa Tubuh</span>
        </a>
        <a href="{{ route('tidur.analisis') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('tidur.*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition">
            <i class="fas fa-moon text-lg text-indigo-300"></i>
            <span class="{{ request()->routeIs('tidur.*') ? 'font-medium' : '' }}">Pelacak Tidur</span>
        </a>
        <a href="{{ route('training.workouts') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('training.workouts') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition">
            <i class="fas fa-dumbbell text-lg text-orange-300"></i>
            <span class="{{ request()->routeIs('training.workouts') ? 'font-medium' : '' }}">Daftar Latihan</span>
        </a>
        <a href="{{ route('training.schedule') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('training.schedule*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition">
            <i class="fas fa-calendar-alt text-lg text-cyan-300"></i>
            <span class="{{ request()->routeIs('training.schedule*') ? 'font-medium' : '' }}">Jadwal Latihan</span>
        </a>
        <a href="{{ route('tantangan.progres') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('tantangan.*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition">
            <i class="fas fa-flag text-lg text-purple-300"></i>
            <span class="{{ request()->routeIs('tantangan.*') ? 'font-medium' : '' }}">Tantangan Olahraga</span>
        </a>
        <a href="{{ route('laporan.kesehatan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('laporan.kesehatan*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition">
            <i class="fas fa-chart-bar text-lg text-green-300"></i>
            <span class="{{ request()->routeIs('laporan.kesehatan*') ? 'font-medium' : '' }}">Laporan Kesehatan</span>
        </a>
        
        @if(auth()->user()->is_admin)
        <div class="mt-4 pt-4 border-t border-white border-opacity-20">
            <p class="text-xs text-blue-100 uppercase tracking-wide mb-2 px-4">Admin</p>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition">
                <i class="fas fa-users-cog text-lg text-yellow-300"></i>
                <span class="{{ request()->routeIs('admin.users.*') ? 'font-medium' : '' }}">Kelola Pengguna</span>
            </a>
            <a href="{{ route('admin.tantangan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.tantangan.*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition">
                <i class="fas fa-trophy text-lg text-yellow-300"></i>
                <span class="{{ request()->routeIs('admin.tantangan.*') ? 'font-medium' : '' }}">Kelola Tantangan</span>
            </a>
        </div>
        @endif
    </nav>

    <div class="mt-auto pt-6 border-t border-blue-400">
        <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-500 hover:bg-opacity-20 transition text-red-200 font-medium">
            <i class="fas fa-sign-out-alt text-lg"></i>
            <span>Keluar</span>
        </a>
    </div>
</div>
