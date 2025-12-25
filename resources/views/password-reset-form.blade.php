<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-teal-50 via-cyan-50 to-green-50 min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Logo & Judul -->
        <div class="text-center mb-8">
            <div class="inline-block bg-gradient-to-br from-teal-400 to-cyan-500 p-4 rounded-full mb-4">
                <i class="fas fa-key text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent mb-2">
                Reset Password
            </h1>
            <p class="text-gray-600 text-sm">Buat password baru untuk akun Anda</p>
        </div>

        <!-- Card Form -->
        <div class="bg-white rounded-xl shadow-2xl p-8 border border-teal-100">
            <!-- Status -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                    <p class="text-red-800 text-sm font-semibold flex items-center gap-2 mb-2">
                        <i class="fas fa-times-circle"></i>Gagal
                    </p>
                    <ul class="text-red-700 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.reset.confirm') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token ?? '' }}">
                <input type="hidden" name="email" value="{{ $email ?? '' }}">

                <!-- Email Display -->
                <div class="p-3 bg-gray-100 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Email</p>
                    <p class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-500"></i>
                        {{ $email ?? 'N/A' }}
                    </p>
                </div>

                <!-- Password Baru -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-teal-600 mr-2"></i>Password Baru
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            placeholder="Masukkan password minimal 8 karakter"
                            class="w-full px-4 py-3 border-2 border-teal-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition bg-teal-50"
                            required
                            minlength="8"
                        >
                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="icon-password"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>
                        Minimal 8 karakter, kombinasi huruf dan angka lebih aman
                    </p>
                    @error('password')
                        <span class="text-red-500 text-xs mt-1 block">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-teal-600 mr-2"></i>Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation"
                            placeholder="Ketik ulang password Anda"
                            class="w-full px-4 py-3 border-2 border-teal-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition bg-teal-50"
                            required
                            minlength="8"
                        >
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="icon-password_confirmation"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="text-red-500 text-xs mt-1 block">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Password Strength Indicator -->
                <div>
                    <p class="text-xs text-gray-600 mb-2">Kekuatan Password:</p>
                    <div class="flex gap-1">
                        <div class="flex-1 h-2 bg-gray-200 rounded-full" id="strength-1"></div>
                        <div class="flex-1 h-2 bg-gray-200 rounded-full" id="strength-2"></div>
                        <div class="flex-1 h-2 bg-gray-200 rounded-full" id="strength-3"></div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white font-bold py-3 rounded-lg transition duration-300 transform hover:shadow-lg flex items-center justify-center gap-2"
                >
                    <i class="fas fa-check-circle"></i>
                    Reset Password
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center gap-4">
                <div class="flex-1 h-px bg-gray-300"></div>
                <span class="text-gray-500 text-sm">bantuan</span>
                <div class="flex-1 h-px bg-gray-300"></div>
            </div>

            <!-- Back to Login -->
            <div class="text-center">
                <p class="text-gray-600 text-sm mb-3">Batal reset password?</p>
                <a href="{{ route('login.form') }}" class="inline-flex items-center gap-2 text-teal-600 hover:text-teal-700 font-semibold transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Login
                </a>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
            <p class="text-yellow-800 text-sm flex items-start gap-2">
                <i class="fas fa-lightbulb mt-0.5 flex-shrink-0"></i>
                <span>
                    <strong>Tips:</strong> Gunakan password yang kuat dengan kombinasi huruf besar, huruf kecil, dan angka untuk keamanan maksimal.
                </span>
            </p>
        </div>
    </div>

    <!-- Background Decoration -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-teal-200 to-cyan-200 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-cyan-200 to-green-200 rounded-full opacity-20 blur-3xl"></div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById('icon-' + fieldId);
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;

            const colors = ['bg-gray-200', 'bg-red-500', 'bg-yellow-500', 'bg-green-500'];
            for (let i = 1; i <= 3; i++) {
                const element = document.getElementById('strength-' + i);
                element.className = 'flex-1 h-2 rounded-full ' + (i <= strength ? colors[strength] : 'bg-gray-200');
            }
        });
    </script>
</body>
</html>
