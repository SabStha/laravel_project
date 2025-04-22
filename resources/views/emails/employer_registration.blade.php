<!DOCTYPE html>
<html>
<head>
    <title>登録を完了してください</title>
</head>
<body>
    <p>親愛なる {{ $name }} 様、</p>
    <p>ご登録ありがとうございます。下のボタンをクリックして、会社登録を完了してください。</p>
    <p>
        <a href="{{ $url }}" style="background: #28a745; padding: 10px 20px; color: #fff; text-decoration: none;">
            登録を完了する
        </a>
    </p>
    <p>もしこの登録をリクエストしていない場合は、このメールを無視してください。</p>
</body>
</html>
