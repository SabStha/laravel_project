@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-3">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h3>{{ __('Login') }}</h3>
                    <p class="lead">Welcome back, please log in to continue</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group mb-4">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 rounded-pill">
                                {{ __('Login') }}
                            </button>
                        </div>

                        <!-- Forgot Password Link -->
                        <div class="text-center mt-4">
                            <a class="btn btn-link text-muted" href="{{ url('/forgot-password') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Custom Styles -->
@section('styles')
<style>
    /* General Styles */
    body {
        background: #f8f9fa;
        font-family: 'Roboto', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1000px;
        width: 100%;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, #007bff, #00d4ff);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 30px 20px;
    }

    .card-header h3 {
        font-size: 2rem;
        font-weight: 600;
    }

    .card-header p {
        font-size: 1.1rem;
        font-weight: 300;
    }

    .card-body {
        padding: 30px;
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
    }

    .form-label {
        font-weight: 600;
        font-size: 1.1rem;
        color: #333;
    }

    .form-control {
        border-radius: 10px;
        padding: 15px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        border-color: #007bff;
    }

    .invalid-feedback {
        color: #e74c3c;
        font-size: 0.9rem;
    }

    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 15px 20px;
        font-size: 1.2rem;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-link {
        color: #007bff;
        text-decoration: none;
    }

    .btn-link:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .card {
            padding: 20px;
        }

        .btn-primary {
            font-size: 1rem;
            padding: 12px 16px;
        }
    }
</style>
@endsection
