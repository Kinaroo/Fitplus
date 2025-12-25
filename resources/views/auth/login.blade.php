<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-cyan-50 to-lime-50 antialiased flex items-center justify-center">
    <div class="w-full max-w-md mx-auto px-4">
        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 rounded-xl bg-gradient-to-br from-blue-400 to-green-400 flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c.9-1 2-2.1 3-3 1-1 2-2 3-2s2 0 2 1-1 2-1 2c0 1-1 2-1 3s0 2 1 3 2 1 2 2-1 2-2 2-3 0-4 0-2 0-3-1-2-2-3-3-1-2-1-3c0-1 0-2 1-3 1-1 1-2 2-2s1 0 2 1c1 1 2 2 3 3z"/>
                </svg>
            </div>
            <a href="{{ route('home') }}" class="block mt-3 text-teal-600 font-semibold text-lg">FitPlus</a>
            <p class="text-gray-600 text-sm">Platform Kesehatan Digital Anda</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-2 justify-center mb-4 text-teal-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A4.992 4.992 0 0112 15c1.657 0 3.156.805 4 2.04M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <h3 class="font-semibold">Masuk</h3>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border border-red-100 text-red-700 text-sm rounded-md p-3 mb-4">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com" class="w-full border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-200" />
                    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-200" />
                    @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end mb-4">
                    @if (Illuminate\Support\Facades\Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Lupa Password?</a>
                    @endif
                </div>

                <button type="submit" class="w-full py-3 rounded-full text-white font-semibold bg-gradient-to-r from-blue-500 via-teal-400 to-green-400 hover:opacity-95 transition">Masuk</button>
            </form>

            <div class="text-center mt-5">
                <a href="{{ route('register.form') }}" class="text-sm text-blue-600 hover:underline">Belum punya akun? Daftar di sini</a>
            </div>
        </div>
    </div>
</body>
</html>