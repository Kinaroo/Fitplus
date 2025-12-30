<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - FitPlus')</title>
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
                <h1 class="text-2xl font-bold">@yield('page-title', 'Admin Panel')</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-300">{{ auth()->user()->nama ?? 'Admin' }} • {{ now()->locale('id')->format('l, j F Y') }}</span>
                    <i class="fas fa-user-circle text-2xl"></i>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-8">
                @if ($errors->any())
                    <div class="max-w-6xl mx-auto mb-6">
                        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
                                <div>
                                    <p class="text-red-800 font-semibold">Terjadi kesalahan:</p>
                                    <ul class="mt-2 text-red-700 text-sm list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="max-w-6xl mx-auto mb-6">
                        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-green-600"></i>
                                <p class="text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
