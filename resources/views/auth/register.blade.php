@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <!-- User Type Selection -->
                    <div class="row mb-3">
                        <label for="user_type" class="col-md-4 col-form-label text-md-end">{{ __('User Type') }}</label>

                        <div class="col-md-6">
                            <select id="user_type" name="user_type" required onchange="toggleForms()">
                                <option value="user" {{ old('user_type') == 'user' ? 'selected' : '' }}>{{ __('User') }}</option>
                                <option value="employee" {{ old('user_type') == 'employee' ? 'selected' : '' }}>{{ __('Employee') }}</option>
                                <option value="jobseeker" {{ old('user_type') == 'jobseeker' ? 'selected' : '' }}>{{ __('Jobseeker') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- User Registration Form -->
                    <div id="user" style="display: none;">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Employee Registration Form -->
                    <div id="employee" style="display: none;">
                        <h1>Employee Registration</h1>
                        <form method="POST" action="{{ route('employee.register') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="employee_id" class="col-md-4 col-form-label text-md-end">{{ __('Employee ID') }}</label>
                                <div class="col-md-6">
                                    <input id="employee_id" type="text" class="form-control" name="employee_id" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="department" class="col-md-4 col-form-label text-md-end">{{ __('Department') }}</label>
                                <div class="col-md-6">
                                    <input id="department" type="text" class="form-control" name="department" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="position" class="col-md-4 col-form-label text-md-end">{{ __('Position') }}</label>
                                <div class="col-md-6">
                                    <input id="position" type="text" class="form-control" name="position" required>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register as Employee') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Jobseeker Registration Form -->
                    <div id="jobseeker" style="display: none;">
                        <h1>Jobseeker Registration</h1>
                        <!-- Add your jobseeker registration form here -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleForms() {
        var userType = document.getElementById('user_type').value;
        var userForm = document.getElementById('user');
        var employeeForm = document.getElementById('employee');
        var jobseekerForm = document.getElementById('jobseeker');

        // Hide all forms first
        userForm.style.display = 'none';
        employeeForm.style.display = 'none';
        jobseekerForm.style.display = 'none';

        // Show form based on user type selection
        if (userType === 'user') {
            userForm.style.display = 'block';
        } else if (userType === 'employee') {
            employeeForm.style.display = 'block';
        } else if (userType === 'jobseeker') {
            jobseekerForm.style.display = 'block';
        }
    }

    // Call function on page load to set the correct visibility based on the selected user type
    document.addEventListener('DOMContentLoaded', function() {
        toggleForms();
    });
</script>

@endsection
