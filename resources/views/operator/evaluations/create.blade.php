@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('求職者評価') }} - {{ $jobseeker->user->name }}
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('operator.submitEvaluation', $jobseeker->user_id) }}">
                        @csrf

                        @foreach($evaluationAxes as $axis)
                            <div class="mb-4">
                                <label class="form-label">{{ $axis->name }}</label>
                                <div class="d-flex align-items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="score[{{ $axis->id }}]" 
                                                id="score_{{ $axis->id }}_{{ $i }}" 
                                                value="{{ $i }}" 
                                                required>
                                            <label class="form-check-label" for="score_{{ $axis->id }}_{{ $i }}">
                                                {{ $i }}
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                                <div class="mt-2">
                                    <label class="form-label">{{ __('コメント') }}</label>
                                    <textarea class="form-control" 
                                        name="comment[{{ $axis->id }}]" 
                                        rows="2"
                                        maxlength="1000"></textarea>
                                </div>
                            </div>
                        @endforeach

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                {{ __('評価を保存') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
