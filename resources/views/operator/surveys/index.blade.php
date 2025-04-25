@extends('layouts.header')

@section('content')
<div class="container">
    <h2>求職者アンケート結果</h2>
    
    <table class="table">
        <thead>
            <tr>
                <th>名前</th>
                <th>メール</th>
                <th>総スコア</th>
                <th>アンケート完了</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobseekers as $jobseeker)
                <tr>
                    <td>{{ $jobseeker->name }}</td>
                    <td>{{ $jobseeker->email }}</td>
                    <td>{{ $jobseeker->total_score }}</td>
                    <td>{{ $jobseeker->survey_completed ? '完了' : '未完了' }}</td>
                    <td>
                        <a href="{{ route('operator.surveyDetail', $jobseeker->id) }}" class="btn btn-primary">詳細を見る</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
