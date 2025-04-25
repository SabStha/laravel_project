@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-3">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h3>{{ __('オペレーターダッシュボード') }}</h3>
                    <p class="lead">ダッシュボードへようこそ!</p>
                </div>

                <div class="card-body">
                    <div class="text-center">
                        <h4>ようこそ、 {{ Auth::user()->name }}!</h4>
                        <p>求職者の評価を効率的に管理します。</p>
                    </div>


                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('operator.viewJobseekers') }}" class="btn btn-primary w-100 py-3 rounded-pill">
                                {{ __('すべての求職者リストを表示') }}
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('operator.viewEvaluations') }}" class="btn btn-primary w-100 py-3 rounded-pill">
                                {{ __('評価求職者リストを見る') }}
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <<form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger w-50 py-3 rounded-pill">
                                    {{ __('Logout') }}
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
    .btn {
        font-size: 1.2rem;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>
@endsection
