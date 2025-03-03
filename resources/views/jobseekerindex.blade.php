@extends('layouts.header')

@section('content')
<div class="container">
    <h2 class="text-center my-4">All Job Seekers</h2>

    <div class="row">
        @foreach($jobseekers as $jobseeker)
            <div class="col-md-4 mb-4">
                <div class="card shadow-lg rounded-3">
                    <div class="card-body text-center">
                        <img src="{{ $jobseeker->image ? asset('storage/'.$jobseeker->image) : asset('images/default-profile.png') }}" 
                             class="rounded-circle mb-3" width="100" height="100" alt="Profile Image">

                        <h5 class="card-title">{{ $jobseeker->user->name }}</h5>
                        <p class="text-muted">{{ $jobseeker->user->email }}</p>

                        <a href="{{ route('chat.start', $jobseeker->user->id) }}" class="btn btn-info w-100 rounded-pill">
                            Message
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
