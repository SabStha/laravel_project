@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-3">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h3>{{ __('雇用主登録') }}</h3> <!-- Employer Registration -->
                    <p class="lead">サインアップして、求人情報を投稿してみましょう！</p> <!-- Sign up and post job listings -->
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('employer.register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="form-group mb-4">
                            <label for="name" class="form-label">{{ __('氏名') }}</label> <!-- Full Name -->
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">{{ __('メールアドレス') }}</label> <!-- E-Mail Address -->
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group mb-4">
                            <label for="password" class="form-label">{{ __('パスワード') }}</label> <!-- Password -->
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group mb-4">
                            <label for="password-confirm" class="form-label">{{ __('パスワード確認') }}</label> <!-- Confirm Password -->
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <!-- Additional fields for employer -->
                        <div class="form-group mb-4">
                            <label for="company_name" class="form-label">{{ __('会社名') }}</label> <!-- Company Name -->
                            <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name">
                            @error('company_name')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="company_address" class="form-label">{{ __('会社住所') }}</label> <!-- Company Address -->
                            <input id="company_address" type="text" class="form-control @error('company_address') is-invalid @enderror" name="company_address" value="{{ old('company_address') }}" required autocomplete="company_address">
                            @error('company_address')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="company_phone" class="form-label">{{ __('会社電話番号') }}</label>
                            <input id="company_phone" type="tel" class="form-control @error('company_phone') is-invalid @enderror" name="company_phone" value="{{ old('company_phone') }}" required autocomplete="tel">
                            @error('company_phone')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 rounded-pill">
                                {{ __('登録する') }} <!-- Register -->
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p>すでにアカウントをお持ちですか？ <a href="{{ route('login') }}" class="text-primary">こちらからログイン</a></p> <!-- Already have an account? Login here -->
                    </div>
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
        background: url('{{ asset('images/homeimg.jpg') }}') no-repeat center center/cover;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        font-family: 'Noto Sans JP', sans-serif;
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        align-items: center;
    }

    .container {
        max-width: 1200px;
        width: 100%;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, #007bff, #00d4ff);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 40px 20px;
    }

    .card-header h3 {
        font-size: 2rem;
        font-weight: 600;
    }

    .card-body {
        padding: 30px 40px;
        background-color: rgba(255, 255, 255, 0.85); /* Slight opacity to blend with background */
        border-radius: 15px;
    }

    .form-label {
        font-weight: 600;
        font-size: 1.1rem;
        color: #333;
    }

    /* Form Fields */
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

    /* Submit Button */
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

    /* Link Styling */
    .text-primary {
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .text-primary:hover {
        color: #0056b3;
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
