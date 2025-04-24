@extends('layouts.header')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>求職者登録</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('jobseeker.register') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- 名前 -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">名前 *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- メールアドレス -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">メールアドレス *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- パスワード -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">パスワード *</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- パスワード（確認） -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">パスワード（確認） *</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <!-- 性別 -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">性別 *</label>
                            <select name="gender" class="form-control" required>
                                @foreach($genders as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 生年月日 -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">生年月日 *</label>
                            <input type="date" name="birthday" class="form-control" required>
                        </div>

                        <!-- 国籍 -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">国籍 *</label>
                            <select name="citizenship" id="citizenship" class="form-control" required>
                                @foreach($citizenships as $key => $label)
                                    <option value="{{ is_numeric($key) ? $label : $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- その他の国籍 -->
                        <div class="form-group mb-3" id="custom-citizenship-section" style="display: none;">
                            <label class="font-weight-bold">新しい国名を入力してください *</label>
                            <input type="text" name="custom_citizenship" id="custom-citizenship" class="form-control" placeholder="国名を入力">
                        </div>

                        <script>
                            document.getElementById('citizenship').addEventListener('change', function() {
                                var customSection = document.getElementById('custom-citizenship-section');
                                if (this.value === 'その他') {
                                    customSection.style.display = 'block';
                                } else {
                                    customSection.style.display = 'none';
                                }
                            });
                        </script>

                        <!-- 学校名 -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">学校名 *</label>
                            <select name="school" class="form-control" required>
                                @foreach($schools as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- アルバイトが必要か -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">今すぐにアルバイトが必要ですか？ *</label>
                            <select name="parttimejob" id="parttimejob" class="form-control" required>
                                <option value="1">はい</option>
                                <option value="0">いいえ</option>
                            </select>
                        </div>

                        <!-- 希望勤務時間 -->
                        <div class="form-group mb-3" id="work-hours-section">
                            <label class="font-weight-bold">週に何時間ぐらい働きたいですか？ *</label>
                            <input type="number" name="time" id="time" class="form-control" min="1" max="28" 
                                   value="{{ old('time') }}" {{ old('parttimejob') == '1' ? 'required' : '' }}>
                        </div>

                        <!-- 希望時給 -->
                        <div class="form-group mb-3" id="wage-section" style="display: none;">
                            <label class="font-weight-bold">新しいアルバイトに求める時給の最低額はいくらですか？ *</label>
                            <select name="wage" class="form-control">
                                @foreach($wageOptions as $wage)
                                    <option value="{{ $wage }}">{{ $wage }}円以上</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 日本語能力試験 -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">日本語能力試験（JLPT） *</label>
                            <select name="jlpt" class="form-control" required>
                                @foreach($jlptLevels as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 卒業見込み年 -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">卒業見込みの年 *</label>
                            <div>
                                @foreach(range(date('Y'), date('Y') + 6) as $year)
                                    <div class="form-check">
                                        <input type="radio" name="expected_to_graduate" id="grad_year_{{ $year }}" 
                                               value="{{ $year }}" class="form-check-input" required
                                               {{ old('expected_to_graduate') == $year ? 'checked' : '' }}>
                                        <label class="form-check-label" for="grad_year_{{ $year }}">{{ $year }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- 登録ボタン -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-lg btn-success">登録する</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('parttimejob').addEventListener('change', function() {
        var workHoursSection = document.getElementById('work-hours-section');
        var wageSection = document.getElementById('wage-section');

        if (this.value == '1') {
            workHoursSection.style.display = 'block';
            wageSection.style.display = 'none';
        } else {
            workHoursSection.style.display = 'none';
            wageSection.style.display = 'block';
        }
    });
</script>
@endsection
