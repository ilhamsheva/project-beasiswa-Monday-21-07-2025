{{-- File: resources/views/auth/login.blade.php --}}

@extends('components.layouts.app')

{{-- Menambahkan style kustom ke dalam layout --}}
@push('styles')
<style>
    /* Wrapper untuk memberikan background dan menengahkan form */
    .login-page-wrapper {
        background-color: #007bff;
        font-family: 'Segoe UI', sans-serif;
        /* DIUBAH: Pastikan mengambil tinggi penuh layar */
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }

    .login-container {
        background-color: #fff;
        padding: 40px 30px;
        border-radius: 10px;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 420px;
    }

    .login-title {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
        font-size: 30px;
        font-weight: 600;
    }

    .login-container form {
        display: flex;
        flex-direction: column;
    }

    .login-container label {
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }

    .login-container input[type="email"],
    .login-container input[type="password"] {
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    .login-container input[type="email"]:focus,
    .login-container input[type="password"]:focus {
        outline: none;
        border-color: #007bff;
    }

    .login-container button {
        padding: 12px;
        background-color: #007bff;
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .login-container button:hover {
        background-color: #0056b3;
    }

    .login-container .form-check-label {
        font-weight: normal;
        color: #555;
    }

    .login-links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
    }

    .login-links a {
        color: #007bff;
        text-decoration: none;
        font-size: 14px;
    }
    .login-links a:hover {
        text-decoration: underline;
    }

    /* Untuk menampilkan error validasi */
    .invalid-feedback {
        display: block;
        margin-top: -15px;
        margin-bottom: 15px;
        font-size: 13px;
    }
</style>
@endpush

@section('content')
<div class="login-page-wrapper">
    <div class="login-container">
        <h2 class="login-title">{{ __('Login') }}</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email Address --}}
            <label for="email">{{ __('Alamat Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            {{-- Password --}}
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            {{-- Remember Me & Forgot Password --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Ingat Saya') }}
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 14px; text-decoration: none;">
                        {{ __('Lupa Password?') }}
                    </a>
                @endif
            </div>

            {{-- Tombol Login --}}
            <button type="submit">
                {{ __('Login') }}
            </button>

            {{-- Link ke Register --}}
            <div class="text-center mt-3 login-links">
                <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
