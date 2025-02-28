@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg rounded-3">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h3>{{ __('Jobseeker Management') }}</h3>
                    <p class="lead">View and manage all jobseeker details.</p>
                </div>

                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('operator.viewJobseekers') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="name" class="form-control" placeholder="Search by Name" value="{{ request('name') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="email" class="form-control" placeholder="Search by Email" value="{{ request('email') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="parttimejob" class="form-control">
                                    <option value="">Part-time Job</option>
                                    <option value="1" {{ request('parttimejob') == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ request('parttimejob') == '0' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="wage" class="form-control" placeholder="Min Wage" value="{{ request('wage') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="time" class="form-control">
                                    <option value="">Preferred Work Time</option>
                                    <option value="1" {{ request('time') == '1' ? 'selected' : '' }}>Morning</option>
                                    <option value="2" {{ request('time') == '2' ? 'selected' : '' }}>Afternoon</option>
                                    <option value="3" {{ request('time') == '3' ? 'selected' : '' }}>Evening</option>
                                </select>
                            </div>
                            <div class="col-md-12 text-center mt-3">
                                <button type="submit" class="btn btn-primary w-25">Search</button>
                            </div>
                        </div>
                    </form>

                    <!-- Jobseeker List Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Evaluation</th>
                                    <th>Score</th>
                                    <th>Survey Completed</th>
                                    <th>Part-Time Job</th>
                                    <th>Wage</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobseekers as $jobseeker)
                                    <tr>
                                        <td>{{ $jobseeker->id }}</td>
                                        <td>{{ $jobseeker->user->name }}</td>
                                        <td>{{ $jobseeker->user->email }}</td>
                                        <td>{{ $jobseeker->phone }}</td>
                                        <td>{{ ucfirst($jobseeker->evaluation) }}</td>
                                        <td>{{ $jobseeker->total_score }}</td>
                                        <td>{{ $jobseeker->survey_completed ? 'Yes' : 'No' }}</td>
                                        <td>{{ $jobseeker->parttimejob ? 'Yes' : 'No' }}</td>
                                        <td>{{ $jobseeker->wage }}</td>
                                        <td>
                                            @if($jobseeker->time == 1) Morning
                                            @elseif($jobseeker->time == 2) Afternoon
                                            @elseif($jobseeker->time == 3) Evening
                                            @else - @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $jobseekers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
