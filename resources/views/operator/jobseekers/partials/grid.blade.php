@extends('layouts.header')

{{-- <style>
/* ========== グローバルスタイル ========== */
body {
    background-color: #fdf7e4;
    font-family: 'Poppins', sans-serif;
}

.chat-container {
    max-width: 900px;
    margin: auto;
    background: #FFFCF9;
    border-radius: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.chat-header {
    background: #FFCAD4;
    color: white;
    padding: 15px;
    font-weight: bold;
    text-align: center;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

.chat-box {
    height: 500px;
    overflow-y: auto;
    padding: 20px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    position: relative;
}

.message {
    padding: 12px;
    margin: 5px 0;
    border-radius: 20px;
    max-width: 75%;
    font-weight: bold;
}

.message.sent {
    background: #FFD3B6;
    color: black;
    align-self: flex-end;
}

.message.received {
    background: #A8E6CF;
    align-self: flex-start;
}

.red-badge {
    background: red;
    color: white;
    font-size: 12px;
    font-weight: bold;
    border-radius: 50%;
    padding: 5px 10px;
    margin-left: auto;
}

.delete-btn {
    background: none;
    border: none;
    color: red;
    font-size: 20px;
    cursor: pointer;
}

.pagination {
    margin-top: 2rem;
}

.jobseeker-card {
    background: #fff;
    padding: 1rem;
    border-radius: 16px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    text-align: center;
    width: 100%;
}

.jobseeker-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
}

.jobseeker-name {
    font-size: 1.2rem;
    font-weight: 700;
    margin-top: 0.5rem;
}

.jobseeker-info {
    font-size: 0.9rem;
    margin-top: 1rem;
}

.survey-completed,
.survey-not-completed {
    font-size: 0.9rem;
    padding: 6px 14px;
    border-radius: 25px;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.btn-outline-secondary {
    font-size: 1.2rem;
    width: 44px;
    height: 44px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
}

/* ========== モバイル専用スタイル ========== */
@media (max-width: 767px) {
    html {
        font-size: 22px;
    }

    .offcanvas.offcanvas-end {
        width: 90% !important;
    }

    #filterForm .form-label {
        font-size: 1rem !important;
        font-weight: 700;
        margin-bottom: 0.2rem;
    }

    #filterForm .form-control {
        font-size: 1.05rem !important;
        padding: 0.8rem 1rem !important;
        border-radius: 10px !important;
    }

    #filterForm .col-12.col-sm-6.col-md-3 {
        flex: 0 0 50% !important;
        max-width: 50% !important;
        padding: 8px !important;
    }

    #filterForm button.btn-lg {
        font-size: 1.1rem !important;
        padding: 12px 20px !important;
        border-radius: 12px !important;
    }

    .text-muted.fw-bold {
        font-size: 1.1rem !important;
        margin: 1rem 0 0.5rem;
    }

    #jobseekerContainer {
        display: flex !important;
        flex-wrap: wrap !important;
        justify-content: space-between !important;
        gap: 1rem;
        padding: 0 1rem;
    }

    .col-6 {
        flex: 0 0 48% !important;
        max-width: 48% !important;
    }

    .jobseeker-card {
        aspect-ratio: 1 / 1;
        padding: 1rem;
    }

    .jobseeker-image {
        width: 100px !important;
        height: 100px !important;
        margin-bottom: 1rem;
    }

    .jobseeker-name {
        font-size: 1.3rem !important;
        font-weight: 800 !important;
    }

    .view-details-btn {
        font-size: 1rem !important;
        padding: 12px 14px !important;
        border-radius: 30px;
        width: 100%;
    }

    .jobseeker-info {
        display: none !important;
    }
}
</style> --}}

<div id="jobseekerContainer" class="row g-4">
    @foreach($jobseekers as $jobseeker)
        <div class="col-6 col-md-4 col-lg-3 d-flex">
            <div class="jobseeker-card w-100 position-relative">

                {{-- ✅ チャットボタン --}}
                <div class="text-end mb-2">
                    <!-- モバイル用：アイコンのみ -->
                    <a href="{{ route('chat.start', $jobseeker->user->id) }}" class="btn btn-outline-secondary d-inline-block d-md-none">
                        📩
                    </a>

                    <!-- デスクトップ用：フルボタン -->
                    <a href="{{ route('chat.start', $jobseeker->user->id) }}" class="btn btn-info w-100 rounded-pill d-none d-md-inline-block">
                        📩 チャット
                    </a>
                </div>

                <div class="text-center">
                    <img src="{{ $jobseeker->image && file_exists(public_path('images/' . $jobseeker->image)) 
                        ? asset('images/' . $jobseeker->image) 
                        : asset('images/placeholder-shadow.png') }}" 
                        class="jobseeker-image mb-3" alt="プロフィール画像">
                </div>

                <h5 class="jobseeker-name">{{ ucfirst($jobseeker->user->name) }}</h5>

                {{-- ✅ 主な情報（デスクトップでのみ表示） --}}
                <div class="jobseeker-info d-none d-md-block">
                    <p><strong>🎓 学校:</strong> {{ $jobseeker->school ?? 'N/A' }}</p>
                    <p><strong>📧 メール:</strong> {{ $jobseeker->user->email ?? 'N/A' }}</p>
                    <p><strong>🌎 国籍:</strong> {{ $jobseeker->citizenship ?? 'N/A' }}</p>
                    <p><strong>🎓 卒業予定:</strong> {{ $jobseeker->expected_to_graduate ?? 'N/A' }}</p>
                    <p><strong>⚧ 性別:</strong> {{ ucfirst($jobseeker->gender ?? 'N/A') }}</p>
                    <p><strong>🎂 年齢:</strong> 
                        {{ $jobseeker->birthday ? \Carbon\Carbon::parse($jobseeker->birthday)->age : 'N/A' }}
                    </p>
                    <p><strong>📜 JLPT:</strong> {{ $jobseeker->jlpt ?? 'N/A' }}</p>
                    <p><strong>💰 最低賃金:</strong> ¥{{ number_format($jobseeker->wage) ?? 'N/A' }}</p>
                </div>

                {{-- ✅ サーベイの状態 --}}
                <p class="{{ $jobseeker->survey_completed ? 'survey-completed' : 'survey-not-completed' }}">
                    {{ $jobseeker->survey_completed ? '✅ サーベイ完了' : '❌ サーベイ未完了' }}
                </p>

                {{-- ✅ 詳細表示ボタン --}}
                <div class="text-center mt-2">
                    <a href="{{ route('operator.jobseeker.details', $jobseeker->id) }}" class="btn btn-outline-primary w-100 view-details-btn">
                        🔍 詳細を見る
                    </a>
                    
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- ページネーション -->
<div class="d-flex justify-content-center mt-4">
    {{ $jobseekers->links('pagination::bootstrap-4') }}
</div>
