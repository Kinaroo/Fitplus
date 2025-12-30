<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Latihan - FitPlus</title>
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
                <h1 class="text-2xl font-bold"><i class="fas fa-calendar-alt mr-3"></i>Jadwal Latihan</h1>
                <div class="flex items-center gap-4">
                    <form method="POST" action="{{ route('training.schedule.generate') }}">
                        @csrf
                        <button type="submit" class="bg-white text-teal-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition font-medium">
                            <i class="fas fa-sync-alt mr-2"></i>Generate Jadwal Baru
                        </button>
                    </form>
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
                @endif

                <!-- User BMI Info -->
                <div class="bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl p-6 text-white mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <p class="text-teal-100 text-sm">BMI Anda</p>
                            <p class="text-3xl font-bold">{{ number_format($bmi, 1) }}</p>
                            <p class="text-sm text-teal-200">{{ $bmiCategory }}</p>
                        </div>
                        <div>
                            <p class="text-teal-100 text-sm">Berat Badan</p>
                            <p class="text-3xl font-bold">{{ $user->berat ?? '-' }} <span class="text-lg">kg</span></p>
                        </div>
                        <div>
                            <p class="text-teal-100 text-sm">Tinggi Badan</p>
                            <p class="text-3xl font-bold">{{ $user->tinggi ?? '-' }} <span class="text-lg">cm</span></p>
                        </div>
                        <div>
                            <p class="text-teal-100 text-sm">Level Latihan</p>
                            <p class="text-3xl font-bold">{{ ucfirst($recommendedLevel) }}</p>
                            <p class="text-sm text-teal-200">Berdasarkan BMI</p>
                        </div>
                    </div>
                </div>

                <!-- Weekly Schedule -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <h2 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-calendar-week mr-2 text-teal-600"></i>
                            Jadwal Latihan Mingguan Anda
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">Jadwal dipersonalisasi berdasarkan BMI dan kondisi fisik Anda</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach($schedule as $day => $daySchedule)
                            <div class="border rounded-xl overflow-hidden {{ $daySchedule['isRestDay'] ? 'bg-gray-50' : 'bg-white' }}">
                                <div class="px-4 py-3 {{ $daySchedule['isRestDay'] ? 'bg-gray-200' : 'bg-gradient-to-r from-teal-500 to-cyan-500' }} {{ $daySchedule['isRestDay'] ? 'text-gray-700' : 'text-white' }}">
                                    <h3 class="font-bold">{{ $day }}</h3>
                                    <p class="text-sm {{ $daySchedule['isRestDay'] ? 'text-gray-500' : 'text-teal-100' }}">
                                        {{ $daySchedule['focus'] }}
                                    </p>
                                </div>
                                <div class="p-4">
                                    @if($daySchedule['isRestDay'])
                                        <div class="text-center py-6">
                                            <i class="fas fa-bed text-4xl text-gray-300 mb-2"></i>
                                            <p class="text-gray-500">Hari Istirahat</p>
                                            <p class="text-xs text-gray-400 mt-1">Pulihkan otot Anda</p>
                                        </div>
                                    @else
                                        <div class="space-y-3">
                                            @foreach($daySchedule['exercises'] as $exercise)
                                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                                <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-dumbbell text-teal-600 text-sm"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-medium text-gray-800 text-sm truncate" title="{{ $exercise['name'] }}">
                                                        {{ $exercise['name'] }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $exercise['sets'] }} set × {{ $exercise['reps'] }} rep
                                                    </p>
                                                    <p class="text-xs text-teal-600">{{ ucfirst($exercise['muscle']) }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="mt-4 pt-3 border-t text-center">
                                            <span class="text-xs text-gray-500">
                                                <i class="fas fa-clock mr-1"></i>{{ $daySchedule['duration'] }} menit
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Tips Section -->
                <div class="mt-6 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-xl p-6 text-white">
                    <h3 class="font-bold text-lg mb-3"><i class="fas fa-lightbulb mr-2"></i>Tips Latihan untuk {{ $bmiCategory }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($tips as $tip)
                        <div class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-purple-200 mt-1"></i>
                            <p class="text-purple-100">{{ $tip }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
