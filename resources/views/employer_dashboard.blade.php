@extends('layouts.header')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded-4">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h2 class="fw-bold">{{ __('雇用者ダッシュボード') }}</h2>
                    <p class="lead mb-0">ダッシュボードへようこそ！会社の求人情報などを管理しましょう。</p>
                </div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>ようこそ、{{ Auth::user()->name }}さん！</h4>
                    <p>雇用者として正常にログインしています。</p>

                    <!-- 🚀 Display Job Application Notifications Here -->
                    @if(auth()->user()->notifications->count() > 0)
                        <div class="alert alert-warning text-start">
                            <h5><strong>応募通知：</strong></h5>
                            @foreach(auth()->user()->notifications as $notification)
                                <p class="mb-2">
                                    <strong>{{ $notification->data['message'] }}</strong>
                                </p>
                            @endforeach
                        </div>
                    @endif

                    <!-- Check if employer has completed registration -->
                    @if(Auth::user()->employer && Auth::user()->employer->status === 'registered')
                        <a href="{{ route('employer.editRegistrationForm') }}" class="btn btn-warning w-50 py-3 rounded-pill mb-3">
                            {{ __('登録内容を編集') }}
                        </a>
                    @else
                        <a href="{{ route('employer.completeRegistrationForm', ['token' => Auth()->user()->employer->verification_token]) }}" class="btn btn-danger w-50 py-3 rounded-pill mb-3">
                            {{ __('登録を完了する') }}
                        </a>
                    @endif

                    <!-- Jobs Section -->
                    @if(Auth::user()->employer && Auth::user()->employer->status === 'registered')
                        <a href="{{ route('jobs_create') }}" class="btn btn-success w-50 py-3 rounded-pill mb-3">
                            {{ __('求人を作成') }}
                        </a>
                        <a href="{{ route('jobs.index') }}" class="btn btn-primary w-50 py-3 rounded-pill mb-3">
                            {{ __('求人一覧を見る') }}
                        </a>
                    @endif

                    <!-- View Job Seekers -->
                    <a href="{{ route('jobseekers.index') }}" class="btn btn-primary w-50 py-3 rounded-pill mb-3">
                        {{ __('求職者一覧を見る') }}
                    </a>

                    <!-- Chat -->
                    <a href="{{ route('chat.index') }}" class="btn btn-info w-50 py-3 rounded-pill mb-3">
                        {{ __('チャット') }}
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger w-50 py-3 rounded-pill">
                            {{ __('ログアウト') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
