@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded-3">
                <div class="card-header text-center bg-warning text-white py-4">
                    <h3>{{ __('Jobseeker Evaluations') }}</h3>
                    <p class="lead">Manage and review evaluations for jobseekers.</p>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Jobseeker Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Evaluation Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobseekers as $jobseeker)
                                    <tr>
                                        <td>{{ $jobseeker->name }}</td>
                                        <td>{{ $jobseeker->email }}</td>
                                        <td>
                                            @if ($jobseeker->isEvaluated)
                                                <span class="badge bg-success">{{ __('Evaluated') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('Not Evaluated') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($jobseeker->isEvaluated)
                                                <a href="{{ route('operator.editEvaluation', ['user_id' => $jobseeker->id]) }}" 
                                                class="btn btn-warning btn-sm">
                                                    {{ __('Edit Evaluation') }}
                                                </a>
                                            @else
                                                <a href="{{ route('operator.evaluate', ['user_id' => $jobseeker->user_id]) }}" 
                                                class="btn btn-primary btn-sm">
                                                    {{ __('Evaluate Now') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>


                        </table>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('operator.dashboard') }}" class="btn btn-primary w-100 py-3 rounded-pill">
                            {{ __('Back to Dashboard') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }

    .table td {
        font-size: 1.1rem;
    }

    .table th {
        font-size: 1.2rem;
        background-color: #f8f9fa;
    }

    .table-responsive {
        margin-top: 20px;
    }

    .badge {
        font-size: 1rem;
        font-weight: bold;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 1rem;
    }

    .list-group-item {
        font-size: 1.1rem;
    }
</style>
<script>
    function showEvaluationForm(jobseekerId) {
        let formRow = document.getElementById('evaluation-form-' + jobseekerId);
        if (formRow) {
            formRow.style.display = formRow.style.display === 'none' ? 'table-row' : 'none';
        }
    }
</script>
@endsection
