
@extends('layouts.header')

@section('content')
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg p-4">
        <a href="{{ route('operator.viewJobseekers') }}" class="btn btn-primary">
            ⬅ Back to Jobseekers
        </a>
        <div class="text-center">
            <!-- Profile Image -->
            <img src="{{ $jobseeker->image ? asset('storage/' . $jobseeker->image) : asset('images/placeholder-shadow.png') }}" 
                 class="rounded-circle shadow-sm mb-3 d-block mx-auto" width="150" height="150" alt="Profile Image">
        </div>

        <h3 class="text-center fw-bold">{{ ucfirst($jobseeker->user->name ?? 'N/A') }}</h3>
        <p class="text-center text-muted">{{ $jobseeker->user->email ?? 'N/A' }}</p>

        <div class="row mt-4">
            <!-- Left Column -->
            <div class="col-md-6">
                <p><strong>🎓 School:</strong> {{ $jobseeker->school ?? 'N/A' }}</p>
                <p><strong>🌎 Citizenship:</strong> {{ $jobseeker->citizenship ?? 'N/A' }}</p>
                <p><strong>📜 JLPT:</strong> {{ $jobseeker->jlpt ?? 'N/A' }}</p>
                <p><strong>🎂 Age:</strong> {{ \Carbon\Carbon::parse($jobseeker->birthday)->age ?? 'N/A' }}</p>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <p><strong>🏠 Address:</strong> {{ $jobseeker->address ?? 'N/A' }}</p>
                <p><strong>💰 Expected Wage:</strong> ¥{{ number_format($jobseeker->wage) ?? 'N/A' }}</p>
                <p><strong>📅 Graduation Date:</strong> {{ $jobseeker->expected_to_graduate ?? 'N/A' }}</p>
                <p><strong>📞 Phone:</strong> {{ $jobseeker->phone ?? 'N/A' }}</p>
            </div>
        </div>

        <hr>

        <!-- Evaluation -->
        <h4>📝 Evaluation</h4>
        <p>{{ $jobseeker->evaluation ?? 'No evaluation yet' }}</p>

        <!-- Survey Completion Status -->
        <h4>📊 Survey Status</h4>
        <p class="fw-bold">
            {{ $jobseeker->survey_completed ? '✅ Completed' : '❌ Not Completed' }}
        </p>

        <a href="{{ route('jobseekers.index') }}" class="btn btn-dark mt-3">Back to Jobseekers</a>
    </div>
</div>
@endsection
