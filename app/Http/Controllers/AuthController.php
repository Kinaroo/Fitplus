<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

class AuthController extends Controller
{
    // Tampilkan form register
    public function showRegister()
    {
        return view('auth.register');  // Menampilkan form registrasi
    }

    // Handle registrasi
    public function register(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'nama' => 'required|string|max:100|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:255|confirmed',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date|before:today',
        ]);

        try {
            // Siapkan data user
            $userData = [
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? 'L',
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'tingkat_aktivitas' => 1.55,
            ];

            // Buat pengguna baru
            $user = User::create($userData);

            return redirect()->route('login.form')->with('success', 'Akun berhasil dibuat! Silahkan login dengan email dan password Anda.');
        } catch (\Exception $e) {
            \Log::error('Registration error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
            return back()->withErrors(['error' => 'Gagal membuat akun: ' . $e->getMessage()]);
        }
    }

    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');  // Menampilkan form login
    }

    // Handle login
    public function login(Request $request)
    {
        // Validasi kredensial
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Debug logging
        \Log::info('Login attempt', [
            'email' => $request->email,
            'user_found' => $user ? true : false,
            'password_hash' => $user ? substr($user->password, 0, 10) . '...' : null,
        ]);

        // Cek apakah user ada dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Login user
            auth()->loginUsingId($user->id);
            \Log::info('Login success', ['user_id' => $user->id, 'email' => $user->email, 'authenticated' => auth()->check()]);
            return redirect()->intended(route('dashboard'));
        }

        // Jika login gagal
        \Log::warning('Login failed', ['email' => $request->email]);
        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    // Logout user
    public function logout()
    {
        Auth::logout();  // Keluar dari sesi login
        session()->invalidate();  // Invalidate session
        session()->regenerateToken();  // Regenerate token
        return redirect('/');  // Redirect ke homepage
    }

    // Tampilkan profil
    public function showProfil()
    {
        return view('profil.index');  // Menampilkan halaman profil
    }

    // Update profil
    public function updateProfil(Request $request)
    {
        // Validasi data tinggi badan dan berat badan
        $request->validate([
            'tinggi_badan' => 'required|numeric|min:100|max:250',
            'berat_badan' => 'required|numeric|min:20|max:300|regex:/^\d+(\.\d{1,2})?$/',  // Regex untuk berat badan dengan dua angka desimal
        ]);

        // Mengambil data user yang sedang login
        $user = auth()->user();
        $user->tinggi = $request->tinggi_badan;
        $user->berat = $request->berat_badan;
        $user->save();  // Simpan perubahan

        return back()->with('success', 'Profil berhasil diperbarui!');  // Kembali dengan pesan sukses
    }

    /**
     * Tampilkan form lupa password
     */
    public function showPasswordReset()
    {
        return view('password-reset');
    }

    /**
     * Kirim email reset password
     */
    public function sendPasswordReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // For security, don't reveal if email exists
            return back()->with('status', 'Jika email terdaftar, Anda akan menerima link reset password. Silakan cek inbox atau folder spam.');
        }

        // Generate reset token
        $resetToken = \Illuminate\Support\Str::random(60);
        
        // Simpan token ke cache dengan expired 1 jam
        \Illuminate\Support\Facades\Cache::put(
            'password_reset_' . $request->email,
            $resetToken,
            \Carbon\Carbon::now()->addHours(1)
        );

        // Build reset link
        $resetLink = route('password.reset.form', [
            'email' => $request->email,
            'token' => $resetToken
        ]);

        \Log::info('Password reset requested', [
            'email' => $request->email,
            'token' => substr($resetToken, 0, 10) . '...',
            'reset_link' => $resetLink
        ]);

        try {
            // Send email menggunakan Mailable class
            Mail::send(new PasswordResetMail($user, $resetLink));

            \Log::info('Password reset email sent', ['email' => $request->email]);
        } catch (\Exception $e) {
            \Log::error('Failed to send password reset email', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);
        }

        // Return reset link directly for convenience in development
        return back()
            ->with('status', 'Link reset password telah dikirim ke email Anda.')
            ->with('reset_link', $resetLink)
            ->with('show_direct_link', true);
    }

    /**
     * Tampilkan form untuk input password baru
     */
    public function showPasswordResetForm(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        // Validasi token
        if (!$email || !$token || !Cache::has('password_reset_' . $email)) {
            return redirect()->route('password.request')->withErrors(['token' => 'Link reset password tidak valid atau sudah expired']);
        }

        return view('password-reset-form', compact('email', 'token'));
    }

    /**
     * Process password reset
     */
    public function confirmPasswordReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Validasi token
        $storedToken = \Illuminate\Support\Facades\Cache::get('password_reset_' . $request->email);
        if (!$storedToken || $storedToken !== $request->token) {
            return back()->withErrors(['token' => 'Link reset password tidak valid']);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        $user->password_hash = Hash::make($request->password);
        $user->save();

        // Hapus token dari cache
        \Illuminate\Support\Facades\Cache::forget('password_reset_' . $request->email);

        \Log::info('Password reset success', ['email' => $request->email]);

        return redirect()->route('login.form')->with('status', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }
}
