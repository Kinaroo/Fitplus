<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Latihan - FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-gradient-to-r from-teal-700 to-cyan-600 text-white px-8 py-4 flex justify-between items-center shadow-lg">
                <h1 class="text-2xl font-bold"><i class="fas fa-dumbbell mr-3"></i>Daftar Latihan</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-300">Total: {{ $workouts->total() }} latihan</span>
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <!-- Filter Section -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <h3 class="font-bold text-gray-700 mb-4"><i class="fas fa-filter mr-2"></i>Filter Latihan</h3>
                    <form method="GET" action="{{ route('training.workouts') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tingkat Kesulitan</label>
                            <select name="level" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <option value="">Semua Level</option>
                                <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>Pemula (Beginner)</option>
                                <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>Menengah (Intermediate)</option>
                                <option value="expert" {{ request('level') == 'expert' ? 'selected' : '' }}>Ahli (Expert)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Otot Target</label>
                            <select name="muscle" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <option value="">Semua Otot</option>
                                @foreach($muscles as $muscle)
                                    <option value="{{ $muscle }}" {{ request('muscle') == $muscle ? 'selected' : '' }}>{{ ucfirst($muscle) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tipe Gerakan</label>
                            <select name="force" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <option value="">Semua Tipe</option>
                                <option value="push" {{ request('force') == 'push' ? 'selected' : '' }}>Push</option>
                                <option value="pull" {{ request('force') == 'pull' ? 'selected' : '' }}>Pull</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <a href="{{ route('training.workouts') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Level Categories -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <a href="{{ route('training.workouts', ['level' => 'beginner']) }}" 
                       class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6 hover:shadow-lg transition transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold">Pemula</h3>
                                <p class="text-green-100 text-sm">Untuk yang baru mulai</p>
                            </div>
                            <i class="fas fa-seedling text-4xl text-green-200"></i>
                        </div>
                        <p class="mt-2 text-2xl font-bold">{{ $levelCounts['beginner'] ?? 0 }}</p>
                    </a>
                    <a href="{{ route('training.workouts', ['level' => 'intermediate']) }}" 
                       class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl p-6 hover:shadow-lg transition transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold">Menengah</h3>
                                <p class="text-yellow-100 text-sm">Sudah terbiasa berolahraga</p>
                            </div>
                            <i class="fas fa-fire text-4xl text-yellow-200"></i>
                        </div>
                        <p class="mt-2 text-2xl font-bold">{{ $levelCounts['intermediate'] ?? 0 }}</p>
                    </a>
                    <a href="{{ route('training.workouts', ['level' => 'expert']) }}" 
                       class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl p-6 hover:shadow-lg transition transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold">Ahli</h3>
                                <p class="text-red-100 text-sm">Latihan intensif</p>
                            </div>
                            <i class="fas fa-bolt text-4xl text-red-200"></i>
                        </div>
                        <p class="mt-2 text-2xl font-bold">{{ $levelCounts['expert'] ?? 0 }}</p>
                    </a>
                </div>

                <!-- Workout List -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Latihan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Level</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Otot Target</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Peralatan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($workouts as $workout)
                                <tr class="hover:bg-gray-50 transition cursor-pointer" onclick="showDetail({{ $workout->id ?? 0 }}, '{{ addslashes($workout->getName()) }}')">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $workout->getName() }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php $level = $workout->getLevel(); @endphp
                                        @if($level == 'beginner')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-seedling mr-1"></i> Pemula
                                            </span>
                                        @elseif($level == 'intermediate')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-fire mr-1"></i> Menengah
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-bolt mr-1"></i> Ahli
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ ucfirst($workout->getMuscle()) }}</td>
                                    <td class="px-6 py-4">
                                        @if($workout->getForce() == 'push')
                                            <span class="text-blue-600"><i class="fas fa-arrow-up mr-1"></i>Push</span>
                                        @else
                                            <span class="text-purple-600"><i class="fas fa-arrow-down mr-1"></i>Pull</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ ucfirst($workout->{'COL 5'} ?? '-') }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ ucfirst($workout->getCategory()) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        <i class="fas fa-dumbbell text-4xl text-gray-300 mb-3"></i>
                                        <p>Tidak ada latihan ditemukan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 border-t">
                        {{ $workouts->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="modalTitle" class="text-xl font-bold text-gray-800"></h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="modalContent" class="text-gray-600"></div>
            </div>
        </div>
    </div>

    <script>
        function showDetail(id, name) {
            document.getElementById('modalTitle').textContent = name;
            document.getElementById('modalContent').innerHTML = '<p class="text-center"><i class="fas fa-spinner fa-spin text-2xl text-teal-600"></i></p>';
            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.getElementById('detailModal').classList.remove('flex');
        }

        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</body>
</html>
