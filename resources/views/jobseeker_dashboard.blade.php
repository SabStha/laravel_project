@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-3">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h3>{{ __(' 求職者ダッシュボード ') }}</h3>
                    <p class="lead">ダッシュボードへようこそ！応募履歴とプロフィールを管理してください。</p>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="text-center">
                        @auth
                            <h4>ようこそ、 {{ Auth::user()->name }}!</h4>
                            <p>求職者としてログインしました。ここから応募履歴を確認し、管理できます。</p>
                        @else
                            <p>このページにアクセスするにはログインが必要です。</p>
                        @endauth
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                        <a href="{{ route('jobseeker.viewListings') }}" class="btn btn-secondary w-100 py-3 rounded-pill">
                                {{ __('求人情報を閲覧') }}
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('jobseeker.viewApplications') }}" class="btn btn-secondary w-100 py-3 rounded-pill">
                                {{ __(' 応募状況を確認 ') }}
                            </a>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('jobseeker.editProfile') }}" class="btn btn-warning w-100 py-3 rounded-pill">
                                {{ __('プロフィールを編集 ') }}
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('chat.index') }}" class="btn btn-info w-100 py-3 rounded-pill">
                                {{ __('チャット') }}
                            </a>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('jobseeker.saveJobs') }}" class="btn btn-success w-100 py-3 rounded-pill">
                                {{ __(' お気に入りの求人') }}
                            </a>
                        </div>

                        <!-- Logout Form -->
                        <div class="col-md-6 mb-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100 py-3 rounded-pill">
                                    {{ __('ログアウト') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
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
        background-color: rgba(255, 255, 255, 0.85);
        border-radius: 15px;
    }

    .btn {
        font-size: 1.2rem;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .alert {
        font-size: 1.1rem;
        margin-top: 15px;
        border-radius: 10px;
    }
</style>
@endsection
