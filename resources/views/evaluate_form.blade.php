@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-3">
                <div class="card-header text-center bg-warning text-white py-4">
                    <h3>{{ __('Evaluate Jobseeker') }}</h3>
                    <p class="lead">{{ __('Evaluating: ') }} {{ $jobseeker->name }}</p>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4 class="mb-3">Previous Evaluations</h4>

                    @if ($existingEvaluations->isNotEmpty())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Evaluation Axis') }}</th>
                                    <th>{{ __('Rating') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if ($existingEvaluations->isNotEmpty())
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Evaluation Axis') }}</th>
                                            <th>{{ __('Rating') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($existingEvaluations as $evaluation)
                                            <tr>
                                                <td>{{ $evaluation->axis_name ?? 'Unknown' }}</td>
                                                <td>{{ $evaluation->rating ?? 'N/A' }} / 5</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted">{{ __('No evaluations yet. Please evaluate below.') }}</p>
                            @endif

                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">{{ __('No evaluations yet. Please evaluate below.') }}</p>
                    @endif

                    <hr>

                    <h4 class="mb-3">Submit a New Evaluation</h4>

                    <form method="POST" action="{{ route('operator.submitEvaluation', ['user_id' => $jobseeker->user_id]) }}">
                        @csrf
                        <input type="hidden" name="jobseeker_id" value="{{ $jobseeker->id }}">

                        @foreach ($evaluation_axes as $axis)
                            <div class="mb-3">
                                <label class="form-label">{{ __($axis->name) }}</label>
                                <input type="number" name="ratings[{{ $axis->id }}]" min="1" max="5" class="form-control" required>
                            </div>
                        @endforeach

                        <div class="text-center">
                            <button type="submit" class="btn btn-success">{{ __('Submit Evaluation') }}</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('operator.viewEvaluations') }}" class="btn btn-secondary">
                            {{ __('Back to Evaluations') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
