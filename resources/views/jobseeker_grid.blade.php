@extends('layouts.header')

@section('content')
<div class="d-flex justify-content-between align-items-center my-3">
    <a href="{{ route('operator.dashboard') }}" class="btn btn-outline-dark btn-lg">⬅ 戻る</a>
</div>

<div class="container text-center mb-4">
    <h2 class="fw-bold">🔍 求職者管理</h2>
    <p class="lead text-muted">求職者情報の閲覧、検索、および管理を効率的に行えます。</p>
</div>

<div class="container">
    @php
        $hasAdvancedFilters = request()->filled('name') || request()->filled('email') || collect(request('surveys'))->filter()->isNotEmpty();
        $surveys = $surveyQuestions;
    @endphp

    <form id="filterForm" class="row g-3 mb-3" method="GET" action="{{ route('operator.viewJobseekers') }}">
        {{-- ✅ Basic Filters --}}
        <div class="col-md-3">
            <label class="form-label">⚧ 性別</label>
            <select name="gender" class="form-control">
                <option value="">すべて</option>
                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>男</option>
                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>女</option>
                <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>他</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">🎓 卒業年</label>
            <select name="graduation_year" class="form-control">
                <option value="">選択してください</option>
                @foreach($graduationDates as $year)
                    <option value="{{ $year }}" {{ request('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">🏫 学校</label>
            <select name="school" class="form-control">
                <option value="">選択してください</option>
                @foreach($schools as $school)
                    <option value="{{ $school }}" {{ request('school') == $school ? 'selected' : '' }}>{{ $school }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">🌎 国籍</label>
            <select name="citizenship" class="form-control">
                <option value="">選択してください</option>
                @foreach($citizenships as $citizenship)
                    <option value="{{ $citizenship }}" {{ request('citizenship') == $citizenship ? 'selected' : '' }}>{{ $citizenship }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">📜 JLPT</label>
            <select name="jlpt" class="form-control">
                <option value="">選択してください</option>
                @foreach($jlptLevels as $level)
                    <option value="{{ $level }}" {{ request('jlpt') == $level ? 'selected' : '' }}>{{ $level }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">💰 時給（以上）</label>
            <select name="wage" class="form-control">
                <option value="">指定なし</option>
                @foreach($wages as $wage)
                    <option value="{{ $wage }}" {{ request('wage') == $wage ? 'selected' : '' }}>¥{{ number_format($wage) }}以上</option>
                @endforeach
            </select>
        </div>


{{-- 🔘 詳細検索：アンケート回答でフィルター --}}
<div class="col-md-12">
    <button
        class="btn btn-outline-dark w-100"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#surveyAnswerFilters"
        aria-expanded="{{ request()->has('survey_answers') ? 'true' : 'false' }}"
        aria-controls="surveyAnswerFilters">
        🧠 アンケート回答で絞り込み
        @if(request()->has('survey_answers'))
            <span class="badge bg-danger ms-2">使用中</span>
        @endif
    </button>

    <div class="collapse mt-3 {{ request()->has('survey_answers') ? 'show' : '' }}" id="surveyAnswerFilters">
        <div class="row">
            @foreach($surveys as $survey)
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $survey->question_text }}</label>
                    <select name="survey_answers[{{ $survey->id }}]" class="form-control">
                        <option value="">-- 回答を選択 --</option>
                        <option value="a" {{ request("survey_answers.{$survey->id}") == 'a' ? 'selected' : '' }}>
                            A: {{ $survey->option_a }}
                        </option>
                        <option value="b" {{ request("survey_answers.{$survey->id}") == 'b' ? 'selected' : '' }}>
                            B: {{ $survey->option_b }}
                        </option>
                        <option value="c" {{ request("survey_answers.{$survey->id}") == 'c' ? 'selected' : '' }}>
                            C: {{ $survey->option_c }}
                        </option>
                        <option value="d" {{ request("survey_answers.{$survey->id}") == 'd' ? 'selected' : '' }}>
                            D: {{ $survey->option_d }}
                        </option>
                    </select>
                </div>
            @endforeach
        </div>
    </div>
</div>



<div class="col-md-12">
    <!-- 📊 Toggle Button -->
    <button
        class="btn btn-outline-dark w-100"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#advancedFiltersBox"
        aria-expanded="{{ $hasAdvancedFilters ? 'true' : 'false' }}"
        aria-controls="advancedFiltersBox">
        📊 詳細検索（名前・メール）
        @if($hasAdvancedFilters)
            <span class="badge bg-danger ms-2">使用中</span>
        @endif
    </button>

    <!-- 🔽 Collapsible Section -->
    <div class="collapse mt-3 {{ $hasAdvancedFilters ? 'show' : '' }}" id="advancedFiltersBox">
        <div class="row">
            <!-- 👤 名前 -->
            <div class="col-md-6">
                <label class="form-label">🔍 名前</label>
                <input type="text" name="name" class="form-control" placeholder="求職者の名前を入力してください" value="{{ request('name') }}">
            </div>

            <!-- 📧 メール -->
            <div class="col-md-6">
                <label class="form-label">📧 メール</label>
                <input type="text" name="email" class="form-control" placeholder="メールアドレスをご入力ください" value="{{ request('email') }}">
            </div>
        </div>
    </div>
</div>



        {{-- 🔍 Submit --}}
        <div class="col-md-12 text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">🔎 検索</button>
        </div>
    </form>

    <!-- 📋 Jobseeker Grid -->
    <div id="jobseekerContainer" class="row g-4">
        @include('jobseeker_grid_partial', ['jobseekers' => $jobseekers])
    </div>

    @if($jobseekers->isEmpty())
        <p class="text-center text-danger">求職者が見つかりませんでした</p>
    @endif
</div>
@endsection
