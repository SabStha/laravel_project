@extends('layouts.header')

@section('content')
<div class="container">
    <h2>{{ $jobseeker->name }} のアンケート結果</h2>
    <p><strong>メール:</strong> {{ $jobseeker->email }}</p>
    <p><strong>合計スコア:</strong> {{ $jobseeker->total_score }}</p>
    
    <table class="table">
        <thead>
            <tr>
                <th>質問</th>
                <th>選択した回答</th>
                <th>スコア</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($survey_responses as $response)
                <tr>
                    <td>{{ $response->question_text }}</td>
                    <td>{{ $response->selected_option }}</td>
                    <td>{{ $response->score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('operator.surveyResults') }}" class="btn btn-secondary">戻る</a>
</div>
@endsection
