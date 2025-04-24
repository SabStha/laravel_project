@extends('layouts.header')

@section('content')
<div class="container my-5">
    <!-- resources/views/jobsShow.blade.php -->
    <h4>評価基準:</h4>
    <ul>
    @foreach($job->jobEvaluationAxes as $evaluation)
        <li>{{ $evaluation->evaluationAxis->name }}: {{ $evaluation->rating }}/5</li>
    @endforeach
    </ul>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="fw-bold">{{ $job->title }}</h2>
                    <p class="lead">投稿日: {{ $job->created_at->format('Y-m-d') }}</p>
                </div>

                <div class="card-body">
                    <p><strong>カテゴリー:</strong> {{ $job->category->name ?? 'カテゴリなし' }}</p>
                    <p><strong>勤務地:</strong> {{ $job->location }}</p>
                    <p><strong>給与:</strong> {{ $job->salary }}</p>
                    <p><strong>仕事内容:</strong> {{ $job->description }}</p>

                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary mt-3">求人一覧に戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
