@foreach($jobseekers as $jobseeker)
<div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card shadow-lg border-0 rounded-lg p-3">
            <div class="card-body">
                <!-- Profile Image (Still Centered) -->
                <div class="text-center">
                    <img src="{{ $jobseeker->image && file_exists(public_path('images/' . $jobseeker->image)) ? asset('images/' . $jobseeker->image) : asset('images/placeholder-shadow.png') }}" 
                        class="rounded-circle shadow-sm mb-3 d-block mx-auto img-fluid" width="100" height="100" alt="Profile Image">

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
                <a href="{{ route('jobseekers.show', $jobseeker->id) }}" class="fw-bold text-primary">
                    {{ ucfirst($jobseeker->user->name) }}
                </a>
                
            </div>
        </div>
    </div>
@endforeach


<!-- Pagination Links -->


<div class="d-flex justify-content-center mt-4">
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm">
            {{ $jobseekers->links('pagination::bootstrap-4') }}
        </ul>
    </nav>
</div>

