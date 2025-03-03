<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせ内容</title>
</head>
<body>

    <h2>新しいお問い合わせがありました</h2>
    <p><strong>名前:</strong> {{ $request->name }}</p>
    <p><strong>メールアドレス:</strong> {{ $request->email }}</p>
    <p><strong>問い合わせ内容:</strong></p>
    <p>{{ $request->message }}</p>

    <p>サポートチームからの対応をお待ちください。</p>

</body>
</html>
