@extends('layouts.header')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded-4">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h2 class="fw-bold">{{ __('Your Job Listings') }}</h2>
                    <p class="lead mb-0">Manage the jobs you have posted.</p>
                </div>

                <div class="card-body">
                    @if($jobs->isEmpty())
                        <p class="text-center">No job listings found. <a href="{{ route('jobs.create') }}">Create a Job</a></p>
                    @else
                        <table class="table table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Posted Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobs as $job)
                                    <tr>
                                        <td>{{ $job->title }}</td>
                                        <td>{{ $job->category->name ?? 'No Category' }}</td>
                                        
                                        <td>{{ $job->location }}</td>
                                        <td>{{ $job->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $jobs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
