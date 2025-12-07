@extends('layouts.app')

@section('title', 'Login - FitPlus')

@section('content')
    <div class="card" style="max-width: 500px; margin: 2rem auto;">
        <h2>Login</h2>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <p style="margin-top: 1rem;">Belum punya akun? <a href="{{ route('register.form') }}">Register di sini</a></p>
    </div>
@endsection