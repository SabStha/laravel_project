@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('メールアドレスの確認が必要です') }}</div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    <p>{{ __('確認リンクをあなたのメールアドレスに送信しました。受信トレイを確認し、リンクをクリックしてメールアドレスを確認してください。') }}</p>

                    <p>{{ __("メールが届かない場合は？") }}</p>
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ __('確認メールを再送信') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
