@extends('layouts.header')

@section('content')
<div class="container">
    <h2>パスワードを忘れましたか？</h2>

    <!-- 成功メッセージ -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- エラーメッセージ -->
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email">登録済みのメールアドレスを入力してください</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">リセットリンクを送信</button>
    </form>
</div>
@endsection
