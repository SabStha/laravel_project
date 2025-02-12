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
        /* Remove margin and padding to ensure full screen */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%; /* Ensure body and html take up full viewport height */
        }

        body {
            font-family: 'Noto Sans JP', sans-serif;
            background: url('{{ asset('images/homeimg.jpg') }}') no-repeat center center/cover;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensure the body covers full viewport height */
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 20px;
            flex-grow: 1; /* Ensures the container takes up remaining space */
        }

        .header {
            margin-top: 50px;
        }

        .header h1 {
            font-size: 3rem;
            color: #fff;
        }

        .header p {
            font-size: 1.5rem;
            color: #ddd;
            margin: 10px 0 30px;
        }

        .search-bar {
            display: flex;
            justify-content: center;
            margin-bottom: 50px;
        }

        .search-bar select, .search-bar input, .search-bar button {
            padding: 10px;
            margin: 0 5px;
            font-size: 1rem;
        }

        .search-bar input {
            flex-grow: 1;
            min-width: 300px;
        }

        .search-bar button {
            background-color: #000;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .auth-buttons {
            margin-top: 20px;
        }

        .auth-buttons a {
            text-decoration: none;
            color: #fff;
            background: #000;
            padding: 10px 20px;
            margin: 5px;
            display: inline-block;
        }

        footer {
            color: #fff;
            margin-top: auto; /* Ensures the footer stays at the bottom */
            padding: 20px 0; /* Optional: adds padding to the footer */
            text-align: center;
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

        <!-- Auth Links -->
        <div class="auth-buttons">
            @if (Route::has('login'))
                <div class="flex flex-col items-center space-y-4">
                    @auth
                        <a href="{{ url('/home') }}" class="w-48 px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 text-lg font-semibold">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-48 px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 text-lg font-semibold">
                            Login
                        </a>

                        @if (Route::has('register'))
                        <a href="{{ route('jobseeker.register') }}" class="btn btn-primary">
                                Register
                        </a>
                        @endif
                    @endauth
                </div>
            @endif
            
            <!-- Register as Employer Button -->
            <div class="mt-4">
                <a href="{{ route('employer.register') }}" class="w-48 px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 text-lg font-semibold">
                    Register as Employer
                </a>
            </div>
        </div>

        <footer>
            <p>© 2025 求人サイト. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
