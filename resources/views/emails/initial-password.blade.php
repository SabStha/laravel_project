<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }
        .password-box {
            background: #fff;
            padding: 15px;
            margin: 20px 0;
            border: 1px solid #ddd;
            border-radius: 3px;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>システムアカウントのパスワードについて</h1>
        </div>
        
        <div class="content">
            <p>{{ $name }}様</p>
            
            <p>お世話になっております。<br>
            システムへのアクセス用パスワードをお知らせいたします。</p>
            
            <div class="password-box">
                <p><strong>ログインメールアドレス:</strong><br>{{ $email }}</p>
                <p><strong>初期パスワード:</strong><br>{{ $password }}</p>
            </div>
            
            <p><strong>ログイン手順:</strong></p>
            <ol>
                <li>下記のURLからログイン画面にアクセスしてください。<br>
                <a href="{{ env('APP_URL') }}/login" class="button">ログイン画面へ</a>
                </li>
                <li>メールアドレスと初期パスワードを入力してログインしてください。</li>
                <li>セキュリティ保持のため、初回ログイン後にパスワードの変更をお願いいたします。</li>
            </ol>
            
            <p><strong>注意事項:</strong></p>
            <ul>
                <li>このメールに記載されているパスワードは初期パスワードです。</li>
                <li>セキュリティ確保のため、できるだけ早くパスワードを変更してください。</li>
                <li>このメールは送信専用のため、返信はできません。</li>
            </ul>
            
            <p>ご不明な点がございましたら、システム管理者までお問い合わせください。</p>
        </div>
        
        <div style="margin-top: 30px; font-size: 12px; color: #666; text-align: center;">
            <p>このメールは自動送信されています。</p>
        </div>
    </div>
</body>
</html>