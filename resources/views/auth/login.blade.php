@extends('layouts.frontend')

@section('content')
<style>
    .login-container {
        min-height: 70vh; /* cukup tinggi agar gak terlalu pendek */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
    }
    .login-card {
        background-color: rgba(255, 255, 255, 0.95); /* transparan putih supaya nyatu */
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(255, 87, 51, 0.2);
        max-width: 450px;
        width: 100%;
        padding: 2rem 2rem;
        transition: box-shadow 0.3s ease;
    }
    .login-card:hover {
        box-shadow: 0 12px 35px rgba(255, 87, 51, 0.35);
    }
    .login-card .card-header {
        border-bottom: none;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .login-card .card-header h3 {
        color: #FF5733;
        font-weight: 700;
        font-size: 1.8rem;
        letter-spacing: 1.3px;
    }
    label {
        font-weight: 600;
        color: #333;
    }
    .form-control {
        border: 2px solid #FFC300;
        border-radius: 8px;
        transition: border-color 0.3s ease;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        color: #212529;
        background-color: #fff;
    }
    .form-control:focus {
        border-color: #FF5733;
        box-shadow: 0 0 8px rgba(255, 87, 51, 0.4);
        outline: none;
        background-color: #fff;
    }
    .btn-primary {
        background: linear-gradient(90deg, #FF5733, #FFC300);
        border: none;
        font-weight: 700;
        padding: 0.6rem 1.8rem;
        border-radius: 8px;
        width: 100%;
        font-size: 1.1rem;
        transition: background 0.4s ease;
        box-shadow: 0 6px 12px rgba(255, 87, 51, 0.4);
    }
    .btn-primary:hover {
        background: linear-gradient(90deg, #FFC300, #FF5733);
        box-shadow: 0 8px 20px rgba(255, 87, 51, 0.6);
    }
    .form-check-label {
        user-select: none;
        font-weight: 500;
        color: #555;
    }
    .invalid-feedback {
        font-size: 0.875rem;
        color: #d6336c;
        margin-top: 0.25rem;
    }
</style>

<div class="login-container">
    <div class="login-card shadow-sm">
        <div class="card-header">
            <h3>{{ __('LOGIN') }}</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email">{{ __('Email Address') }}</label>
                    <input
                        id="email"
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        autofocus
                        placeholder="email@umepersada.com"
                    />
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password">{{ __('Password') }}</label>
                    <input
                        id="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        autocomplete="current-password"
                        placeholder="Enter your password"
                    />
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- <div class="mb-4 form-check">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        id="remember"
                        name="remember"
                        {{ old('remember') ? 'checked' : '' }}
                    />
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div> -->

                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>

            </form>
        </div>
    </div>
</div>
@endsection
