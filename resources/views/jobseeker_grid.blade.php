@extends('layouts.header')

@section('content')

<div class="container text-center mb-4">
    <div class="d-flex justify-content-between align-items-center my-3">
        <a href="{{ route('operator.dashboard') }}" class="btn btn-outline-dark btn-lg">
            ⬅ 戻る
        </a>
    </div>
    <h2 class="fw-bold">🔍 ジョブシーカー管理</h2>
    <p class="lead text-muted">ジョブシーカーの詳細を効率的に閲覧、検索、管理します。</p>
</div>

<div class="container">
    <!-- 検索とフィルターフォーム -->
    <form id="filterForm" class="row g-3 mb-4" method="GET" action="{{ route('operator.viewJobseekers') }}">

        <!-- 🏆 メイン検索項目 -->
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label">⚧ 性別</label>
            <select name="gender" class="form-control">
                <option value="">すべて</option>
                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>男性</option>
                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>女性</option>
                <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>その他</option>
            </select>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label">🌎 国籍</label>
            <select name="citizenship" class="form-control">
                <option value="">国籍を選択</option>
                @foreach($citizenships as $citizenship)
                    <option value="{{ $citizenship }}" {{ request('citizenship') == $citizenship ? 'selected' : '' }}>
                        {{ $citizenship }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label">📜 JLPTレベル</label>
            <select name="jlpt" class="form-control">
                <option value="">レベルを選択</option>
                @foreach($jlptLevels as $level)
                    <option value="{{ $level }}" {{ request('jlpt') == $level ? 'selected' : '' }}>{{ $level }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label">💰 最低賃金</label>
            <select name="wage" class="form-control">
                <option value="">最低賃金を選択</option>
                @foreach($wages as $wage)
                    <option value="{{ $wage }}" {{ request('wage') == $wage ? 'selected' : '' }}>
                        ¥{{ number_format($wage) }}以上
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label">✨ 評価</label>
            <select name="evaluation" class="form-control">
                <option value="">評価を選択</option>
            </select>
        </div>

        @foreach($jobseekers as $jobseeker)
            <!-- ✅ 詳細表示ボタン — ループ内に必ず配置 -->
            <div class="collapse mt-3" id="detailSearchFields">
                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label">🔍 名前で検索</label>
                        <input type="text" name="name" class="form-control" placeholder="ジョブシーカーの名前を入力" value="{{ request('name') }}">
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label">📧 メールで検索</label>
                        <input type="text" name="email" class="form-control" placeholder="メールアドレスを入力" value="{{ request('email') }}">
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label">🏫 学校</label>
                        <select name="school" class="form-control">
                            <option value="">学校を選択</option>
                            @foreach($schools as $school)
                                <option value="{{ $school }}" {{ request('school') == $school ? 'selected' : '' }}>{{ $school }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label">🎓 卒業年</label>
                        <select name="graduation_date" class="form-control">
                            <option value="">年を選択</option>
                            @foreach($graduationDates as $date)
                                @php
                                    $year = \Carbon\Carbon::parse($date)->format('Y');
                                @endphp
                                <option value="{{ $date }}" {{ request('graduation_date') == $date ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- 🕵️‍♂️ 詳細検索項目 -->

        <!-- 🔎 検索ボタン -->
        <div class="col-md-12 text-center mt-3">
            <button type="submit" class="btn btn-primary btn-lg">🔎 検索</button>
            <a href="{{ route('operator.viewJobseekers') }}" class="btn btn-secondary btn-lg ms-2">🔄 検索をリセット</a>
        </div>
    </form>

    <!-- ジョブシーカーカード -->
    @if($jobseekers->count())
        <p class="text-center text-muted fw-bold">=== {{ $jobseekers->count() }} 件の結果 ===</p>
    @endif

    <div id="jobseekerContainer" class="row g-4">
        @include('jobseeker_grid_partial', ['jobseekers' => $jobseekers])
    </div>

    <!-- ✅ ジョブシーカー詳細オフキャンバスパネル -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="jobseekerDetailsCanvas" aria-labelledby="jobseekerDetailsLabel">
        <div class="offcanvas-header bg-primary text-white">
            <h5 class="offcanvas-title fw-bold" id="jobseekerDetailsLabel">
                <i class="fa-solid fa-user-circle me-2"></i> ジョブシーカー詳細
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="閉じる"></button>
        </div>
        <div class="offcanvas-body" id="jobseekerDetailContent">
            <!-- JavaScriptが内容をここに注入します -->
        </div>
    </div>

    @if($jobseekers->isEmpty())
        <p class="text-center text-danger">ジョブシーカーが見つかりませんでした。</p>
    @endif
</div>

<script>
document.querySelectorAll('.view-details-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const jobseeker = JSON.parse(this.getAttribute('data-jobseeker'));
        const container = document.getElementById('jobseekerDetailContent');

        container.innerHTML = `
            <p><strong>名前:</strong> ${jobseeker.user.name}</p>
            <p><strong>メール:</strong> ${jobseeker.user.email}</p>
            <p><strong>学校:</strong> ${jobseeker.school ?? 'N/A'}</p>
            <p><strong>卒業予定:</strong> ${jobseeker.expected_to_graduate ?? 'N/A'}</p>
            <p><strong>JLPT:</strong> ${jobseeker.jlpt ?? 'N/A'}</p>
            <p><strong>賃金:</strong> ¥${jobseeker.wage ?? 'N/A'}</p>

            <div class="d-grid gap-2 mt-4">
                <a href="/chat/${jobseeker.user.id}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-comment-dots me-2"></i> チャット
                </a>
                <a href="/jobseekers/${jobseeker.id}/edit" class="btn btn-outline-success">
                    <i class="fa-solid fa-pen-to-square me-2"></i> 編集
                </a>
            </div>
        `;
    });
});
</script>

@endsection
