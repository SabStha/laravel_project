<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>求人サイト</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            font-family: 'Noto Sans JP', sans-serif;
            background: url('{{ asset('images/homeimg.jpg') }}') no-repeat center center/cover;
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .header {
            margin-top: 30px;
        }

        .header h1 {
            font-size: 2.2rem;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
        }

        .header p {
            font-size: 1rem;
            color: #ccc;
            margin-bottom: 25px;
        }

        .search-bar {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            max-width: 900px;
            width: 100%;
            margin-bottom: 40px;
        }

        .search-bar select,
        .search-bar input,
        .search-bar button {
            padding: 10px 12px;
            font-size: 1rem;
            border-radius: 6px;
            border: 1px solid #ccc;
            background: #fff;
            color: #000;
            box-sizing: border-box;
            width: 100%;
        }

        @media (min-width: 768px) {
            .search-bar select,
            .search-bar input {
                width: 200px;
            }

            .search-bar button {
                width: 100px;
            }
        }

        .auth-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .auth-buttons a {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 10px auto;
            background: rgba(0, 0, 0, 0.85);
            color: #fff;
            text-decoration: none;
            padding: 12px;
            border-radius: 6px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .auth-buttons a:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        footer {
            text-align: center;
            color: #fff;
            margin-top: auto;
            padding: 20px 0;
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.6rem;
            }

            .search-bar input {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>仕事を探していますか？ ここで検索！</h1>
            <p>日本全国の外国人歓迎の仕事！</p>
        </div>

        <div class="search-bar">
            <select>
                <option>キーワード</option>
            </select>
            <select>
                <option>エリアを選択</option>
            </select>
            <select>
                <option>職種を選択</option>
            </select>
            <input type="text" placeholder="Search">
            <button>検索</button>
        </div>

        <!-- Auth Buttons -->
        <div class="auth-buttons">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">ログイン</a>
                    @if (Route::has('register'))
                        <a href="{{ route('jobseeker.register') }}">求職者として登録</a>
                    @endif
                @endauth
            @endif

            <a href="{{ route('employer.register') }}">企業として登録</a>
        </div>

        <footer>
            <p>© 2025 求人サイト. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
