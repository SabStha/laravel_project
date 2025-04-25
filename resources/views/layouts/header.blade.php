<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <! Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Optionally, include your own CSS file here -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Google Font: Poppins (Cute & Bold) -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<!-- FontAwesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- Custom Styles -->
<!-- <style>
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
    <style>
    @media (max-width: 767px) {
        .jobseeker-card {
            padding: 1rem;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

    .jobseeker-image {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        object-fit: cover;
    }

    .jobseeker-name {
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .view-details-btn,
    .btn-outline-secondary {
        padding: 10px 14px;
        font-size: 15px;
        border-radius: 30px;
    }

    .jobseeker-info,
    .jobseeker-info p {
        display: none !important;
    }

    .jobseeker-card .btn {
        width: 100%;
        margin-top: 10px;
    }

    .chat-button {
        padding: 10px 12px;
        font-size: 16px;
        border-radius: 50%;
    }

    .jobseeker-card .survey-completed,
    .jobseeker-card .survey-not-completed {
        font-size: 14px;
        margin-top: 8px;
        font-weight: 600;
    }
}
</style> -->

{{-- <style>
    @media (max-width: 767px) {
    .jobseeker-card {
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .jobseeker-image {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        object-fit: cover;
    }

    .jobseeker-name {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
    }

    .view-details-btn,
    .btn-outline-secondary {
        padding: 10px 14px;
        font-size: 14px;
        border-radius: 30px;
    }

    .jobseeker-info,
    .jobseeker-info p {
        display: none !important;
    }

    .jobseeker-card .btn {
        width: 100%;
        margin-top: 10px;
    }

    .offcanvas-body {
        padding: 1rem !important;
        overflow-y: auto;
    }

    .container {
        padding: 0 1rem;
    }
}

</style> --}}

<style>
    /* ========== グローバルスタイル ========== */
    body {
        background-color: #fdf7e4;
        font-family: 'Poppins', sans-serif;
    }
    
    .chat-container {
        max-width: 900px;
        margin: auto;
        background: #FFFCF9;
        border-radius: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .chat-header {
        background: #FFCAD4;
        color: white;
        padding: 15px;
        font-weight: bold;
        text-align: center;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    
    .chat-box {
        height: 500px;
        overflow-y: auto;
        padding: 20px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        position: relative;
    }
    
    .message {
        padding: 12px;
        margin: 5px 0;
        border-radius: 20px;
        max-width: 75%;
        font-weight: bold;
    }
    
    .message.sent {
        background: #FFD3B6;
        color: black;
        align-self: flex-end;
    }
    
    .message.received {
        background: #A8E6CF;
        align-self: flex-start;
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
    
    .pagination {
        margin-top: 2rem;
    }
    
    .jobseeker-card {
        background: #fff;
        padding: 1rem;
        border-radius: 16px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        text-align: center;
        width: 100%;
    }
    
    .jobseeker-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .jobseeker-name {
        font-size: 1.2rem;
        font-weight: 700;
        margin-top: 0.5rem;
    }
    
    .jobseeker-info {
        font-size: 0.9rem;
        margin-top: 1rem;
    }
    
    .survey-completed,
    .survey-not-completed {
        font-size: 0.9rem;
        padding: 6px 14px;
        border-radius: 25px;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .btn-outline-secondary {
        font-size: 1.2rem;
        width: 44px;
        height: 44px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
    }
    
    /* ========== モバイル専用スタイル ========== */
    /* @media (max-width: 767px) {
        html {
            font-size: 22px;
        }
    
        .offcanvas.offcanvas-end {
            width: 90% !important;
        }
    
        #filterForm .form-label {
            font-size: 1rem !important;
            font-weight: 700;
            margin-bottom: 0.2rem;
        }
    
        #filterForm .form-control {
            font-size: 1.05rem !important;
            padding: 0.8rem 1rem !important;
            border-radius: 10px !important;
        }
    
        #filterForm .col-12.col-sm-6.col-md-3 {
            flex: 0 0 50% !important;
            max-width: 50% !important;
            padding: 8px !important;
        }
    
        #filterForm button.btn-lg {
            font-size: 1.1rem !important;
            padding: 12px 20px !important;
            border-radius: 12px !important;
        }
    
        .text-muted.fw-bold {
            font-size: 1.1rem !important;
            margin: 1rem 0 0.5rem;
        }
    
        #jobseekerContainer {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: space-between !important;
            gap: 1rem;
            padding: 0 1rem;
        }
    
        .col-6 {
            flex: 0 0 48% !important;
            max-width: 48% !important;
        }
    
        .jobseeker-card {
            aspect-ratio: 1 / 1;
            padding: 1rem;
        }
    
        .jobseeker-image {
            width: 100px !important;
            height: 100px !important;
            margin-bottom: 1rem;
        }
    
        .jobseeker-name {
            font-size: 1.3rem !important;
            font-weight: 800 !important;
        }
    
        .view-details-btn {
            font-size: 1rem !important;
            padding: 12px 14px !important;
            border-radius: 30px;
            width: 100%;
        }
    
        .jobseeker-info {
            display: none !important;
        }
    } */
    
    @media (max-width: 767px) {
      html {
        font-size: 16px; /* Reset overly large scaling */
      }
    
      .container {
        padding: 0 1rem;
      }
    
      .offcanvas.offcanvas-end {
        width: 90% !important;
      }
    
      .jobseeker-card {
        text-align: left !important;
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
        padding: 1rem;
        border-radius: 16px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: space-between;
        background: #fff;
    }
    
    .jobseeker-card p {
        word-break: break-word;
        font-size: 0.95rem;
        margin-bottom: 0.4rem;
    }
    
    .jobseeker-image,
    .jobseeker-name {
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }
    
    
    
    .jobseeker-info {
        text-align: left;
        word-break: break-word;
    }
    
    .jobseeker-info p,
    .jobseeker-info p strong {
        display: block;
        white-space: normal;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    
    
      .view-details-btn,
      .btn-outline-secondary {
        width: 100%;
        padding: 12px 14px;
        font-size: 1rem;
        border-radius: 30px;
        margin-top: 0.5rem;
      }
    
      .survey-completed,
      .survey-not-completed {
        font-size: 0.95rem;
        padding: 6px 14px;
        border-radius: 25px;
        font-weight: 600;
        margin-top: 0.5rem;
      }
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
    
    <!-- Bootstrap CSS (you already have) -->
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html> 
