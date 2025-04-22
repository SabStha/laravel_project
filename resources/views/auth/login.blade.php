@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-3">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h3>{{ __('ログイン') }}</h3>
                    <p class="lead">お帰りなさい、ログインして続けてください。</p>
                </div>

                <div class="card-body">
                    <!-- 登録後の成功メッセージ表示 -->
                    @if (session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- メールアドレス -->
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">{{ __('メールアドレス') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- パスワード -->
                        <div class="form-group mb-4">
                            <label for="password" class="form-label">{{ __('パスワード') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- ログイン状態を保持する -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('ログイン状態を保持する') }}
                            </label>
                        </div>

                        <!-- ログインボタン -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 rounded-pill">
                                {{ __('ログイン') }}
                            </button>
                        </div>

                        <!-- パスワードを忘れた場合のリンクとホームボタン -->
                        <div class="text-center mt-4">
                            <a class="btn btn-secondary btn-lg w-50 mb-2" href="{{ url('/') }}">
                                {{ __('ホームへ') }}
                            </a>
                            <br>
                            <a class
