@extends('layouts.header')

@section('content')
<div class="container">
    <h2>パスワードのリセット</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password">新しいパスワード</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation">パスワード確認</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">パスワードをリセット</button>
    </form>
</div>
@endsection
