@extends('layouts.header')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded-4">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h2 class="fw-bold">{{ __('Employer Dashboard') }}</h2>
                    <p class="lead mb-0">Welcome to your dashboard! Manage your company listings and more.</p>
                </div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Welcome, {{ Auth::user()->name }}!</h4>
                    <p>You're successfully logged in as an Employer.</p>

                    <!-- Check if employer has completed registration -->
                    @if(Auth::user()->employer && Auth::user()->employer->status === 'registered')
                        <!-- Show "Edit Registration" button if already registered -->
                        <a href="{{ route('employer.editRegistrationForm') }}" class="btn btn-warning w-50 py-3 rounded-pill mb-3">
                            {{ __('Edit Registration') }}
                        </a>
                    @else
                        <!-- Show "Complete Registration" button if not registered -->
                        <a href="{{ route('employer.completeRegistrationForm') }}" class="btn btn-danger w-50 py-3 rounded-pill mb-3">
                            {{ __('Complete Registration') }}
                        </a>
                    @endif

                    <!-- Jobs Section -->
                    @if(Auth::user()->employer && Auth::user()->employer->status === 'registered')
                        <a href="{{ route('jobs_create') }}" class="btn btn-success w-50 py-3 rounded-pill mb-3">
                            {{ __('Create Job') }}
                        </a>
                        <a href="{{ route('jobs.index') }}" class="btn btn-primary w-50 py-3 rounded-pill mb-3">
                            {{ __('View Jobs') }}
                        </a>
                    @endif

                    <!-- View Job Seekers -->
                    <a href="{{ route('jobseekers.index') }}" class="btn btn-primary w-50 py-3 rounded-pill mb-3">
                        {{ __('View All Job Seekers') }}
                    </a>

                    <!-- Chat -->
                    <a href="{{ route('chat.index') }}" class="btn btn-info w-50 py-3 rounded-pill mb-3">
                        {{ __('Chats') }}
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger w-50 py-3 rounded-pill">
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
