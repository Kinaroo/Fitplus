<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - FitPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-teal-50 via-cyan-50 to-green-50 min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Logo & Judul -->
        <div class="text-center mb-8">
            <div class="inline-block bg-gradient-to-br from-teal-400 to-cyan-500 p-4 rounded-full mb-4">
                <i class="fas fa-lock-open text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent mb-2">
                Lupa Password?
            </h1>
            <p class="text-gray-600 text-sm">Jangan khawatir, kami akan membantu Anda reset password</p>
        </div>

        <!-- Card Form -->
        <div class="bg-white rounded-xl shadow-2xl p-8 border border-teal-100">
            <!-- Deskripsi -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    Masukkan email yang terdaftar untuk menerima link reset password
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('password.reset.send') }}" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-teal-600 mr-2"></i>Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}"
                        placeholder="masukkan@email.com"
                        class="w-full px-4 py-3 border-2 border-teal-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition bg-teal-50"
                        required
                    >
                    @error('email')
                        <span class="text-red-500 text-xs mt-2 block flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>{{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Status Message -->
                @if ($errors->any())
                    <div class="p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                        <p class="text-red-800 text-sm font-semibold flex items-center gap-2">
                            <i class="fas fa-times-circle"></i>Error
                        </p>
                        <p class="text-red-700 text-sm mt-1">
                            @if ($errors->has('email'))
                                Email tidak terdaftar dalam sistem kami
                            @else
                                Terjadi kesalahan, silakan coba lagi
                            @endif
                        </p>
                    </div>
                @endif

                @if (session('status'))
                    <div class="p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                        <p class="text-green-800 text-sm font-semibold flex items-center gap-2">
                            <i class="fas fa-check-circle"></i>Berhasil
                        </p>
                        <p class="text-green-700 text-sm mt-1">
                            {{ session('status') }}
                        </p>
                        
                        @if (session('show_direct_link') && session('reset_link'))
                            <div class="mt-4 p-3 bg-white rounded border border-green-300">
                                <p class="text-green-800 text-xs font-semibold mb-2">Link Reset Password:</p>
                                <div class="flex gap-2 items-center">
                                    <input 
                                        type="text" 
                                        value="{{ session('reset_link') }}" 
                                        id="resetLink"
                                        class="flex-1 px-2 py-2 text-xs bg-gray-50 border border-gray-300 rounded font-mono"
                                        readonly
                                    >
                                    <button 
                                        type="button"
                                        onclick="copyToClipboard()"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-xs font-semibold transition"
                                    >
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                                <p class="text-green-700 text-xs mt-2">Atau klik link ini: <a href="{{ session('reset_link') }}" class="text-blue-600 hover:underline break-all">{{ session('reset_link') }}</a></p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white font-bold py-3 rounded-lg transition duration-300 transform hover:shadow-lg flex items-center justify-center gap-2"
                >
                    <i class="fas fa-paper-plane"></i>
                    Kirim Link Reset
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center gap-4">
                <div class="flex-1 h-px bg-gray-300"></div>
                <span class="text-gray-500 text-sm">atau</span>
                <div class="flex-1 h-px bg-gray-300"></div>
            </div>

            <!-- Back to Login -->
            <div class="text-center">
                <p class="text-gray-600 text-sm mb-3">Ingat password Anda?</p>
                <a href="{{ route('login.form') }}" class="inline-flex items-center gap-2 text-teal-600 hover:text-teal-700 font-semibold transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Login
                </a>
            </div>
        </div>

        <!-- Footer Help -->
        <div class="mt-8 text-center text-sm text-gray-600">
            <p class="mb-2">Masih mengalami masalah?</p>
            <a href="#" class="text-teal-600 hover:text-teal-700 font-semibold flex items-center justify-center gap-2">
                <i class="fas fa-headset"></i>
                Hubungi Customer Support
            </a>
        </div>
    </div>

    <!-- Background Decoration -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-teal-200 to-cyan-200 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-cyan-200 to-green-200 rounded-full opacity-20 blur-3xl"></div>
    </div>

    <script>
        function copyToClipboard() {
            const resetLink = document.getElementById('resetLink');
            resetLink.select();
            document.execCommand('copy');
            
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
            btn.classList.add('bg-blue-600');
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('bg-blue-600');
            }, 2000);
        }
    </script>
</body>
</html>
