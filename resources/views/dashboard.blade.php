@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-3">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h3>{{ __('Operator Dashboard') }}</h3>
                    <p class="lead">Welcome to your dashboard! Manage your operations effectively.</p>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="text-center">
                        <h4>Welcome, {{ Auth::user()->name }}!</h4>
                        <p>You're successfully logged in. Here you can manage all your operator tasks.</p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('operator.viewListings') }}" class="btn btn-primary w-100 py-3 rounded-pill">
                                {{ __('View Listings') }}
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('operator.manageProfile') }}" class="btn btn-secondary w-100 py-3 rounded-pill">
                                {{ __('Manage Profile') }}
                            </a>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('operator.viewEvaluations') }}" class="btn btn-warning w-100 py-3 rounded-pill">
                                {{ __('評価 (View Evaluations)') }}
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('operator.viewApplications') }}" class="btn btn-success w-100 py-3 rounded-pill">
                                {{ __('View Applications') }}
                            </a>
                        </div>
                    </div>

                    <!-- Add more functionality buttons as needed -->
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('operator.notifications') }}" class="btn btn-info w-100 py-3 rounded-pill">
                                {{ __('Notifications') }}
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                        <form method="POST" action="{{ route('operator.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100 py-3 rounded-pill">
                                {{ __('Logout') }}
                            </button>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Custom Styles -->
@section('styles')
<style>
    /* General Styles */
    body {
        background: url('{{ asset('images/homeimg.jpg') }}') no-repeat center center/cover;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        font-family: 'Noto Sans JP', sans-serif;
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        align-items: center;
    }

    .container {
        max-width: 1200px;
        width: 100%;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, #007bff, #00d4ff);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 40px 20px;
    }

    .card-header h3 {
        font-size: 2rem;
        font-weight: 600;
    }

    .card-body {
        padding: 30px 40px;
        background-color: rgba(255, 255, 255, 0.85); /* Slight opacity to blend with background */
        border-radius: 15px;
    }

    /* Button Styling */
    .btn {
        font-size: 1.2rem;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .alert {
        font-size: 1.1rem;
        margin-top: 15px;
        border-radius: 10px;
    }

    /* Welcome Message */
    .text-center h4 {
        font-size: 1.5rem;
        color: #333;
    }

    .text-center p {
        font-size: 1.1rem;
        color: #666;
    }
</style>
@endsection
