@extends('layouts.header')

@section('content')
<div class="container">
    <h2>Job Listings</h2>

    @foreach($jobs as $job)
        <div class="card mb-3">
            <div class="card-body">
                <h4>{{ $job->title }}</h4>
                <p>{{ $job->description }}</p>
                <p><strong>Location:</strong> {{ $job->location }}</p>
                <p><strong>Salary:</strong> {{ $job->salary }}</p>

                <!-- Display evaluation requirements explicitly -->
                <div>
                    <strong>Evaluation Requirements:</strong>
                    <ul>
                        @foreach($job->jobEvaluationAxes as $evaluation)
                            <li>{{ $evaluation->evaluationAxis->name }}: {{ $evaluation->rating }}/5</li>
                        @endforeach
                    </ul>
                </div>

                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary">View Details</a>
            </div>
        </div>
    @endforeach

    {{ $jobs->links() }}
</div>
@endsection
