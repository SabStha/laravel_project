@extends('layouts.header')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>{{ __('Jobseeker Registration') }}</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('jobseeker.register') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- 名前 (Name) -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">名前 (Name) *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- メールアドレス (Email) -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">メールアドレス (Email) *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Password *</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <!-- 性別 (Gender) -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">性別 (Gender) *</label>
                            <select name="gender" class="form-control" required>
                                @foreach($genders as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 生年月日 (Birthday) -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">生年月日 (Birthday) *</label>
                            <input type="date" name="birthday" class="form-control" required>
                        </div>

                        <!-- 国籍 (Citizenship) -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">国籍 (Citizenship) *</label>
                            <select name="citizenship" id="citizenship" class="form-control" required>
                                @foreach($citizenships as $key => $label)
                                    <option value="{{ is_numeric($key) ? $label : $key }}">{{ is_numeric($key) ? $label : $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Custom Citizenship (Appears only if 'その他' is selected) -->
                        <div class="form-group mb-3" id="custom-citizenship-section" style="display: none;">
                            <label class="font-weight-bold">新しい国名を入力してください *</label>
                            <input type="text" name="custom_citizenship" id="custom-citizenship" class="form-control" placeholder="国名を入力">
                        </div>

                        <script>
                            document.getElementById('citizenship').addEventListener('change', function() {
                                var customCitizenshipSection = document.getElementById('custom-citizenship-section');
                                if (this.value === 'その他') {
                                    customCitizenshipSection.style.display = 'block';
                                } else {
                                    customCitizenshipSection.style.display = 'none';
                                }
                            });
                        </script>


                        <!-- 学校名 (School) -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">学校名 (School) *</label>
                            <select name="school" class="form-control" required>
                                @foreach($schools as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 今すぐにアルバイトが必要ですか？ -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">今すぐにアルバイトが必要ですか？ *</label>
                            <select name="parttimejob" id="parttimejob" class="form-control" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <!-- 週に何時間ぐらい働きたいですか？ -->
                        <div class="form-group mb-3" id="work-hours-section">
                            <label class="font-weight-bold">週に何時間ぐらい働きたいですか？ *</label>
                            <input type="number" name="time" id="time" class="form-control" min="1" max="28" 
                                    value="{{ old('time') }}" {{ old('parttimejob') == '1' ? 'required' : '' }}>

                        </div>

                        

                        <!-- 新しいアルバイトに求める時給の最低額はいくらですか？ -->
                        <div class="form-group mb-3" id="wage-section" style="display: none;">
                            <label class="font-weight-bold">新しいアルバイトに求める時給の最低額はいくらですか？ *</label>
                            <select name="wage" class="form-control">
                                @foreach($wageOptions as $wage)
                                    <option value="{{ $wage }}">{{ $wage }}円以上</option>
                                @endforeach
                            </select>
                        </div>

                        
                        <!-- 日本語能力試験 (JLPT) -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">日本語能力試験 (JLPT) *</label>
                            <select name="jlpt" class="form-control" required>
                                @foreach($jlptLevels as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 卒業見込みの日付 (Expected Graduation Date) -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">卒業見込みの日付 (Expected Graduation Date) *</label>
                            <input type="date" name="expected_to_graduate" class="form-control" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-lg btn-success">登録する (Register)</button>
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
