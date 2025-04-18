@extends('layouts.header')

@section('content')



<div class="container text-center mb-4">
    <div class="d-flex justify-content-between align-items-center my-3">
    <a href="{{ route('operator.dashboard') }}" class="btn btn-outline-dark btn-lg">
        ⬅ Back
    </a>
    </div>
    <h2 class="fw-bold">🔍 Jobseeker Management</h2>
    <p class="lead text-muted">View, search, and manage jobseeker details efficiently.</p>
</div>

<div class="container">
    <!-- Search and Filter Form -->
    <form id="filterForm" class="row g-3 mb-4" method="GET" action="{{ route('operator.viewJobseekers') }}">

        <!-- 🏆 MAIN SEARCH FIELDS -->
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label">⚧ Gender</label>
            <select name="gender" class="form-control">
                <option value="">All</option>
                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label">🌎 Citizenship</label>
            <select name="citizenship" class="form-control">
                <option value="">Select Citizenship</option>
                @foreach($citizenships as $citizenship)
                    <option value="{{ $citizenship }}" {{ request('citizenship') == $citizenship ? 'selected' : '' }}>
                        {{ $citizenship }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label">📜 JLPT Level</label>
            <select name="jlpt" class="form-control">
                <option value="">Select Level</option>
                @foreach($jlptLevels as $level)
                    <option value="{{ $level }}" {{ request('jlpt') == $level ? 'selected' : '' }}>{{ $level }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label">💰 Minimum Wage</label>
            <select name="wage" class="form-control">
                <option value="">Select Min Wage</option>
                @foreach($wages as $wage)
                    <option value="{{ $wage }}" {{ request('wage') == $wage ? 'selected' : '' }}>
                        ¥{{ number_format($wage) }}以上
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label">✨ Evaluation</label>
            <select name="evaluation" class="form-control">
                <option value="">Select Evaluation</option>
                
            </select>
        </div>

        
        @foreach($jobseekers as $jobseeker)
            



                <!-- ✅ View Details Button — must be inside the loop -->
                <div class="collapse mt-3" id="detailSearchFields">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label">🔍 Search by Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter jobseeker's name" value="{{ request('name') }}">
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label">📧 Search by Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Enter email address" value="{{ request('email') }}">
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label">🏫 School</label>
                    <select name="school" class="form-control">
                        <option value="">Select School</option>
                        @foreach($schools as $school)
                            <option value="{{ $school }}" {{ request('school') == $school ? 'selected' : '' }}>{{ $school }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label">🎓 Graduation Year</label>
                    <select name="graduation_date" class="form-control">
                        <option value="">Select Year</option>
                        @foreach($graduationDates as $date)
                            @php
                                $year=\Carbon\Carbon::parse($date)->format('Y');
                            @endphp

                            <option value="{{ $date }}" {{ request('graduation_date') == $date ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


                </div>
            </div>
        @endforeach


        <!-- 🕵️‍♂️ DETAILED SEARCH FIELDS -->
        
        <!-- 🔎 SEARCH BUTTONS -->
        <div class="col-md-12 text-center mt-3">
            <button type="submit" class="btn btn-primary btn-lg">🔎 Search</button>
            <a href="{{ route('operator.viewJobseekers') }}" class="btn btn-secondary btn-lg ms-2">🔄 Clear Search</a>
        </div>
    </form>

    <!-- Jobseeker Cards -->
    @if($jobseekers->count())
    <p class="text-center text-muted fw-bold">=== {{ $jobseekers->count() }} results available ===</p>
    @endif

    <div id="jobseekerContainer" class="row g-4">
        @include('jobseeker_grid_partial', ['jobseekers' => $jobseekers])
    </div>

    <!-- ✅ Jobseeker Offcanvas Panel -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="jobseekerDetailsCanvas" aria-labelledby="jobseekerDetailsLabel">
        <div class="offcanvas-header bg-primary text-white">
            <h5 class="offcanvas-title fw-bold" id="jobseekerDetailsLabel">
                <i class="fa-solid fa-user-circle me-2"></i> Jobseeker Details
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" id="jobseekerDetailContent">
            <!-- JavaScript will inject the content here -->
        </div>
    </div>


    
    @if($jobseekers->isEmpty())
        <p class="text-center text-danger">No jobseekers found.</p>
    @endif
</div>

<script>
document.querySelectorAll('.view-details-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const jobseeker = JSON.parse(this.getAttribute('data-jobseeker'));
        const container = document.getElementById('jobseekerDetailContent');

        container.innerHTML = `
            <p><strong>Name:</strong> ${jobseeker.user.name}</p>
            <p><strong>Email:</strong> ${jobseeker.user.email}</p>
            <p><strong>School:</strong> ${jobseeker.school ?? 'N/A'}</p>
            <p><strong>Graduation:</strong> ${jobseeker.expected_to_graduate ?? 'N/A'}</p>
            <p><strong>JLPT:</strong> ${jobseeker.jlpt ?? 'N/A'}</p>
            <p><strong>Wage:</strong> ¥${jobseeker.wage ?? 'N/A'}</p>

            <div class="d-grid gap-2 mt-4">
                <a href="/chat/${jobseeker.user.id}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-comment-dots me-2"></i> Chat
                </a>
                <a href="/jobseekers/${jobseeker.id}/edit" class="btn btn-outline-success">
                    <i class="fa-solid fa-pen-to-square me-2"></i> Edit
                </a>
            </div>
        `;
    });
});
</script>


@endsection
