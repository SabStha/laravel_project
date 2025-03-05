@extends('layouts.header')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-warning text-white text-center py-4">
                    <h2 class="fw-bold">Edit Job</h2>
                </div>

                <div class="card-body">
                    <form action="{{ route('jobs.update', $job->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Job Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $job->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ $job->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" value="{{ $job->location }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Salary</label>
                            <input type="text" name="salary" class="form-control" value="{{ $job->salary }}">
                        </div>

                        <button type="submit" class="btn btn-warning w-100 py-3 mt-3">Update Job</button>
                    </form>

                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary mt-3 w-100">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
