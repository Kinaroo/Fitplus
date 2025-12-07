<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan form register (view tidak disertakan)
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
        'nama' => 'required|string|max:100|min:3',
        'email' => 'required|email|unique:akun_user,email',
        'password' => 'required|min:6|max:255|confirmed',
        'jenis_kelamin' => 'nullable|in:L,P',
        'tanggal_lahir' => 'nullable|date|before:today',
    ]);

        $user = new User();
        $userData = [
            'nama'=>$request->nama,
            'email'=>$request->email,
            'password'=>$request->password,
            'jenis_kelamin'=>$request->jenis_kelamin ?? 'L',
            'tanggal_lahir'=>$request->tanggal_lahir ?? null,
        ];

        $created = $user->register($userData);
        if (!$created) {
            return back()->withErrors(['gagal' => 'Terjadi kesalahan saat mendaftar']);
        }


        // Login otomatis setelah register
        auth()->loginUsingId($created->id);

        return redirect('/dashboard');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $user = User::authenticate($credentials['email'], $credentials['password']);
        if ($user) {
            auth()->loginUsingId($user->id);
            return redirect('/dashboard');
        }

        return back()->withErrors(['email'=>'Email atau password salah']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showProfil()
    {
        return view('profil.index'); // tampilan profil
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
        'tinggi_badan' => 'required|numeric|min:100|max:250',
        'berat_badan' => 'required|numeric|min:20|max:300|regex:/^\d+(\.\d{1,2})?$/',
    ]);

        $user = auth()->user();
        $user->tinggi_badan = $request->tinggi_badan;
        $user->berat_badan = $request->berat_badan;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

}
