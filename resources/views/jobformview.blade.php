@extends('layouts.header')

@section('content')
<div class="container">
    <h2>求人作成フォーム</h2>

    <!-- 成功メッセージの表示 -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- フォーム開始 -->
    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- エラーメッセージ表示 -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 画像アップロード -->
        <div class="form-group">
            <label for="image">求人画像のアップロード（任意）</label>
            <input type="file" class="form-control" id="image" name="image" onchange="previewImage()">
            @error('image') <span class="text-danger">{{ $message }}</span> @enderror

            <!-- プレビュー -->
            <div id="image-preview-container" class="mt-3" style="display: none;">
                <img id="image-preview" src="" alt="画像プレビュー" class="img-fluid rounded" style="max-width: 300px;">
            </div>
        </div>

        <!-- 雇用者ID -->
        <input type="hidden" name="employer_id" value="{{ $employer->id }}">

        <!-- 職種 -->
        <div class="form-group">
            <label for="title">職種</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- 職務内容 -->
        <div class="form-group">
            <label for="description">仕事内容</label>
            <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- 雇用形態 -->
        <div class="form-group">
            <label for="job_type">雇用形態</label>
            <select class="form-control" id="job_type" name="job_type" required>
                <option value="full" {{ old('job_type') == 'full' ? 'selected' : '' }}>正社員</option>
                <option value="part" {{ old('job_type') == 'part' ? 'selected' : '' }}>アルバイト</option>
                <option value="contract" {{ old('job_type') == 'contract' ? 'selected' : '' }}>契約社員</option>
            </select>
            @error('job_type') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- 勤務日 -->
        <div class="form-group">
            <label for="working_days">勤務日</label><br>
            @php
                $days = ['monday' => '月', 'tuesday' => '火', 'wednesday' => '水', 'thursday' => '木', 'friday' => '金', 'saturday' => '土', 'sunday' => '日'];
            @endphp
            <div class="d-flex flex-wrap gap-2">
                @foreach($days as $key => $label)
                    <input class="btn-check" type="checkbox" id="{{ $key }}" name="working_days[]" value="{{ $key }}"
                        {{ in_array($key, old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
                    <label class="btn btn-outline-primary" for="{{ $key }}">{{ $label }}曜日</label>
                @endforeach
            </div>
            @error('working_days') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- 勤務時間 -->
        <div class="form-group">
            <label for="working_hour">勤務時間</label>
            <input type="text" class="form-control" id="working_hour" name="working_hour" placeholder="例：9:00〜18:00" value="{{ old('working_hour') }}" required>
            @error('working_hour') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- 住所 -->
        <div class="form-group">
            <label for="location">勤務地住所</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
            @error('location') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- 給与 -->
        <div class="form-group">
            <label for="salary">給与</label>
            <input type="text" class="form-control" id="salary" name="salary" value="{{ old('salary') }}">
            @error('salary') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- 必要スキル -->
        <div class="form-group">
            <label for="required_skills">必要なスキル</label>
            <textarea class="form-control" id="required_skills" name="required_skills">{{ old('required_skills') }}</textarea>
            @error('required_skills') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- ビザ要否 -->
        <div class="form-group">
            <label for="visa_required">ビザが必要</label>
            <input type="checkbox" id="visa_required" name="visa_required" value="1" {{ old('visa_required') ? 'checked' : '' }}>
            @error('visa_required') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- 評価軸 -->
        <div class="form-group">
            <label><strong>評価基準</strong></label><br>
            @foreach(App\Models\EvaluationAxis::all() as $axis)
                <div class="mb-2">
                    <label>{{ $axis->name }}</label>
                    <select class="form-control" name="evaluation[{{ $axis->id }}]" required>
                        <option value="">評価を選択</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('evaluation.'.$axis->id) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('evaluation.'.$axis->id) <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            @endforeach
        </div>

        <!-- 送信ボタン -->
        <button type="submit" class="btn btn-primary">求人を作成する</button>
    </form>
</div>
@endsection

<script>
    function previewImage() {
        const file = document.getElementById('image').files[0];
        const previewContainer = document.getElementById('image-preview-container');
        const imagePreview = document.getElementById('image-preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    }
</script>
