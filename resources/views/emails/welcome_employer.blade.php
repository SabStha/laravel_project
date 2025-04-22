<!DOCTYPE html>
<html>
<head>
    <title>雇用者登録完了</title>
</head>
<body>
    <h2>ようこそ、{{ $user->name }} 様！</h2>
    <p>プラットフォームに雇用者として登録いただき、ありがとうございます。</p>
    <p>アカウントが正常に作成されました。</p>
    <p>以下の情報でログインできます：</p>
    <ul>
        <li><strong>メールアドレス:</strong> {{ $user->email }}</li>
        <li><strong>パスワード:</strong> （ご自身で設定したものです）</li>
    </ul>
    <p><a href="{{ url('/login') }}">こちら</a>をクリックして、ログインしてください。</p>
</body>
</html>
