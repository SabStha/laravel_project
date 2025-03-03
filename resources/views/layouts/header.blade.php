<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Optionally, include your own CSS file here -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Google Font: Poppins (Cute & Bold) -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<!-- FontAwesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- Custom Styles -->
<style>
    body {
        background-color: #FFF8E7; /* Pastel yellow */
        font-family: 'Poppins', sans-serif;
    }
    .chat-container {
        max-width: 900px;
        margin: auto;
        background: #FFFCF9; /* Light pastel pink */
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .chat-header {
        background: #FFCAD4; /* Pastel pink */
        color: white;
        padding: 15px;
        font-weight: bold;
        text-align: center;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .chat-list {
        height: 500px;
        overflow-y: auto;
        border-right: 2px solid #FFDDE2; /* Pastel border */
    }
    .chat-item {
        padding: 15px;
        border-bottom: 1px solid #FFE4E1;
        cursor: pointer;
        transition: background 0.3s;
        display: flex;
        align-items: center;
    }
    .chat-item img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
        border: 2px solid white;
    }
    .chat-item:hover {
        background: #FFDDE2; /* Light pastel pink hover */
    }
    .chat-item.active {
        background: #FFB6C1; /* Soft pink */
        color: white;
    }
    .chat-box {
        height: 500px;
        overflow-y: auto;
        padding: 15px;
        background: #fff;
    }
    .message {
        padding: 12px;
        margin: 5px 0;
        border-radius: 20px;
        max-width: 75%;
        font-weight: bold;
    }
    .message.sent {
        background: #FFD3B6; /* Soft pastel orange */
        color: black;
        align-self: flex-end;
    }
    .message.received {
        background: #A8E6CF; /* Soft pastel green */
        align-self: flex-start;
    }
    .chat-footer {
        padding: 10px;
        background: #fff;
        border-top: 2px solid #FFDDE2;
        display: flex;
        align-items: center;
    }
    .red-badge {
        background: red;
        color: white;
        font-size: 12px;
        font-weight: bold;
        border-radius: 50%;
        padding: 5px 10px;
        margin-left: auto;
    }
    .delete-btn {
        background: none;
        border: none;
        color: red;
        font-size: 20px;
        cursor: pointer;
    }
</style>

</head>
<body>
    <div id="app">
        <!-- Navbar, Sidebar, or Header if needed -->

        <main class="py-4">
            @yield('content') <!-- This is where the content of each page will be inserted -->
        </main>
    </div>
    <!-- <div class='container'>
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                        </form>
                    </div>
                    </li>
            @endguest
    </div> -->

    <!-- Bootstrap JS (Optional, if you need it) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
