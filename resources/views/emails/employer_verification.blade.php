<!DOCTYPE html>
<html>
<head>
    <title>雇用者登録を完了してください</title>
</head>
<body>
    <h2>ようこそ、{{ $name }} 様！</h2>
    <p>雇用者として登録が完了しました。ログインする前に、ビジネス登録を完了してください。</p>

    <p><strong>仮パスワード:</strong> {{ $password }}</p>
    <p><strong>登録を完了する:</strong></p>
    
    <a href="{{ $verificationLink }}" style="background-color:#28a745; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;">
        登録を完了する
    </a>

    <p>もし、雇用者アカウントの登録をリクエストしていない場合は、このメールを無視してください。</p>

    <p>ありがとうございます！</p>
</body>
</html>
