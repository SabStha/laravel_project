@extends('layouts.header')

@section('content')
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg p-4">
        <a href="{{ route('operator.viewJobseekers') }}" class="btn btn-primary">
            ⬅ 求職者一覧に戻る
        </a>
        <div class="text-center">
            <!-- プロフィール画像 -->
            <img src="{{ $jobseeker->image && file_exists(public_path('images/' . $jobseeker->image)) 
                        ? asset('images/' . $jobseeker->image) 
                        : asset('images/placeholder-shadow.png') }}" 
                        class="jobseeker-image mb-3" alt="プロフィール画像">
        </div>

        <h3 class="text-center fw-bold">{{ ucfirst($jobseeker->user->name ?? 'N/A') }}</h3>
        <p class="text-center text-muted">{{ $jobseeker->user->email ?? 'N/A' }}</p>

        <div class="row mt-4">
            <!-- 左側のカラム -->
            <div class="col-md-6">
                <p><strong>🎓 学校名:</strong> {{ $jobseeker->school ?? 'N/A' }}</p>
                <p><strong>🌎 国籍:</strong> {{ $jobseeker->citizenship ?? 'N/A' }}</p>
                <p><strong>📜 JLPT:</strong> {{ $jobseeker->jlpt ?? 'N/A' }}</p>
                <p><strong>🎂 年齢:</strong> {{ \Carbon\Carbon::parse($jobseeker->birthday)->age ?? 'N/A' }}</p>
            </div>

            <!-- 右側のカラム -->
            <div class="col-md-6">
                <p><strong>🏠 住所:</strong> {{ $jobseeker->address ?? 'N/A' }}</p>
                <p><strong>💰 希望時給:</strong> ¥{{ number_format($jobseeker->wage) ?? 'N/A' }}</p>
                <p><strong>📅 卒業予定日:</strong> {{ $jobseeker->expected_to_graduate ?? 'N/A' }}</p>
                <p><strong>📞 電話番号:</strong> {{ $jobseeker->phone ?? 'N/A' }}</p>
            </div>
        </div>

        <hr>

        <!-- 評価 -->
        <h4>📝 評価</h4>
        <p>{{ $jobseeker->evaluation ?? '評価はまだありません' }}</p>

        <p class="fw-bold">
            @if($jobseeker->surveyResponses->count() > 0)
                <ul>
                    @foreach($jobseeker->surveyResponses as $response)
                        @php
                            $selectedLetter = $response->selected_option;
                            $survey = $response->survey;
                            $optionText = match ($selectedLetter) {
                                'a' => $survey->option_a,
                                'b' => $survey->option_b,
                                'c' => $survey->option_c,
                                'd' => $survey->option_d,
                                default => '不明な選択肢'
                            };
                        @endphp
                        <li class="mb-3">
                            <strong>Q:</strong> {{ $survey->question_text }}<br>
                            <strong>選択された回答:</strong> {{ strtoupper($selectedLetter) }} — {{ $optionText }}<br>
                            
                        </li>
                    @endforeach
                </ul>
            @else
                <p>アンケートの回答は記録されていません。</p>
            @endif
            </p>
            

        <a href="{{ route('jobseekers.index') }}" class="btn btn-dark mt-3">すべての求職者を見る</a>
    </div>
</div>
@endsection
