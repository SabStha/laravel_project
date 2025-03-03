@foreach($jobseekers as $jobseeker)
    <div class="col-md-3">
        <div class="card shadow-lg border-0 rounded-lg p-3">
            <div class="card-body">
                <!-- Profile Image (Still Centered) -->
                <div class="text-center">
                    <img src="{{ $jobseeker->image ? asset('storage/' . $jobseeker->image) : asset('images/placeholder-shadow.png') }}" 
                         class="rounded-circle shadow-sm mb-3 d-block mx-auto" width="120" height="120" alt="Profile Image">
                </div>

                <!-- Jobseeker Details (Left-Aligned) -->
                <h5 class="fw-bold mb-2">{{ ucfirst($jobseeker->user->name) }}</h5>
                <p class="mb-1"><strong>🎓 School:</strong> {{ $jobseeker->school ?? 'N/A' }}</p>
                <p class="mb-1"><strong>🎓 Email:</strong> {{ $jobseeker->user->email ?? 'N/A' }}</p>
                <p class="mb-1"><strong>🌎 Citizenship:</strong> {{ $jobseeker->citizenship ?? 'N/A' }}</p>
                <p class="mb-1"><strong>🎓 Graduation:</strong> {{ $jobseeker->expected_to_graduate ?? 'N/A' }}</p>
                <p class="mb-1"><strong>⚧ Gender:</strong> {{ ucfirst($jobseeker->gender ?? 'N/A') }}</p>
                <p class="mb-1"><strong>🎂 Age:</strong> 
                    {{ $jobseeker->birthday ? \Carbon\Carbon::parse($jobseeker->birthday)->age : 'N/A' }}
                </p>
                <p class="mb-1"><strong>📜 JLPT:</strong> {{ $jobseeker->jlpt ?? 'N/A' }}</p>
                <p class="mb-1"><strong>💰 Wage:</strong> ¥{{ number_format($jobseeker->wage) ?? 'N/A' }}</p>
                <p class="fw-bold text-success mt-2">
                    {{ $jobseeker->survey_completed ? '✅ Survey Completed' : '❌ Survey Not Completed' }}
                </p>
            </div>
        </div>
    </div>
@endforeach


<!-- Pagination Links -->


<div class="d-flex justify-content-center mt-4">
    {{ $jobseekers->links('pagination::bootstrap-4') }}
</div>
