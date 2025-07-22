{{-- File: resources/views/auth/register.blade.php --}}

@extends('components.layouts.app')

{{-- Menambahkan style kustom ke dalam layout --}}
@push('styles')
<style>
    .register-page-wrapper {
        background-color: #7fec91; /* Warna background hijau sesuai permintaan */
        font-family: 'Segoe UI', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }

    .register-container {
        background-color: #fff;
        padding: 50px 40px;
        border-radius: 15px;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 420px;
    }

    .register-title {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        font-size: 28px;
        font-weight: 600;
    }

    .register-container form {
        display: flex;
        flex-direction: column;
    }

    .register-container label {
        margin-bottom: 6px;
        font-weight: bold;
        color: #333;
        font-size: 15px;
    }

    .register-container input[type="text"],
    .register-container input[type="email"],
    .register-container input[type="password"] {
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
    }

    .register-container input:focus {
        outline: none;
        border-color: #007bff;
    }

    .register-container button {
        padding: 12px;
        background-color: #007bff;
        color: white;
        font-weight: bold;
        font-size: 15px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .register-container button:hover {
        background-color: #0056b3;
    }

    .register-login {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #555;
    }

    .register-login a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    .register-login a:hover {
        text-decoration: underline;
    }

    /* Untuk menampilkan error validasi */
    .invalid-feedback {
        display: block;
        margin-top: -15px;
        margin-bottom: 15px;
        font-size: 13px;
        color: red;
    }
</style>
@endpush

@section('content')
<div class="register-page-wrapper">
    <div class="register-container">
        <h2 class="register-title">{{ __('Register') }}</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name --}}
            <label for="name">{{ __('Nama') }}</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            {{-- Email Address --}}
            <label for="email">{{ __('Alamat Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            {{-- Password --}}
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            {{-- Confirm Password --}}
            <label for="password-confirm">{{ __('Konfirmasi Password') }}</label>
            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">

            {{-- Tombol Register --}}
            <button type="submit" class="mt-3">
                {{ __('Register') }}
            </button>

            {{-- Link ke Login --}}
            <div class="register-login">
                <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
