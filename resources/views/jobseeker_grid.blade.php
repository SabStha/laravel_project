@extends('layouts.header')

@section('content')
<div class="d-flex justify-content-between align-items-center my-3">
    <a href="{{ route('operator.dashboard') }}" class="btn btn-outline-dark btn-lg">
        ⬅ Back to Dashboard
    </a>
</div>


<div class="container text-center mb-4">
    <h2 class="fw-bold">🔍 Jobseeker Management</h2>
    <p class="lead text-muted">View, search, and manage jobseeker details efficiently.</p>
</div>

<div class="container">
        <!-- Search and Filter Form -->
        <form id="filterForm" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">🔍 Search by Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter jobseeker's name">
            </div>
            <div class="col-md-3">
                <label class="form-label">📧 Search by Email</label>
                <input type="text" name="email" class="form-control" placeholder="Enter email address">
            </div>
            <div class="col-md-3">
                <label class="form-label">⚧ Gender</label>
                <select name="gender" class="form-control">
                    <option value="">All</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">🎓 Graduation Year-Month</label>
                <select name="graduation_date" class="form-control">
                    <option value="">Select Date</option>
                    @foreach($graduationDates as $date)
                        <option value="{{ $date }}" {{ request('graduation_date') == $date ? 'selected' : '' }}>{{ $date }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">🏫 School</label>
                <select name="school" class="form-control">
                    <option value="">Select School</option>
                    @foreach($schools as $school)
                        <option value="{{ $school }}">{{ $school }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">🌎 Citizenship</label>
                <select name="citizenship" class="form-control">
                    <option value="">Select Citizenship</option>
                    @foreach($citizenships as $citizenship)
                        <option value="{{ $citizenship }}">{{ $citizenship }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">📜 JLPT Level</label>
                <select name="jlpt" class="form-control">
                    <option value="">Select Level</option>
                    @foreach($jlptLevels as $level)
                        <option value="{{ $level }}">{{ $level }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="wage" class="form-label">💰 Minimum Wage</label>
                <select name="wage" class="form-control">
                    <option value="">Select Min Wage</option>
                    @foreach($wages as $wage)
                        <option value="{{ $wage }}" {{ request('wage') == $wage ? 'selected' : '' }}>
                            ¥{{ number_format($wage) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-lg">🔎 Search</button>
            </div>
        </form>
        
        
    

    <!-- Jobseeker Cards -->
    <div id="jobseekerContainer" class="row g-4">
        @include('jobseeker_grid_partial', ['jobseekers' => $jobseekers])
    </div>
    @if($jobseekers->isEmpty())
        <p class="text-center text-danger">No jobseekers found.</p>
    @endif

</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('operator.viewJobseekers') }}",
                type: "GET",
                data: $(this).serialize(),
                success: function (response) {
                    $('#jobseekerContainer').html($(response).find('#jobseekerContainer').html());
                }
            });
        });
    });
</script>
@endsection
