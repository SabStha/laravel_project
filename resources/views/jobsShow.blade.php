@extends('layouts.header')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="fw-bold">{{ $job->title }}</h2>
                    <p class="lead">Posted on {{ $job->created_at->format('Y-m-d') }}</p>
                </div>

                <div class="card-body">
                    <p><strong>Category:</strong> {{ $job->category->name ?? 'No Category' }}</p>
                    <p><strong>Location:</strong> {{ $job->location }}</p>
                    <p><strong>Salary:</strong> {{ $job->salary }}</p>
                    <p><strong>Description:</strong> {{ $job->description }}</p>

                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary mt-3">Back to Jobs</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
