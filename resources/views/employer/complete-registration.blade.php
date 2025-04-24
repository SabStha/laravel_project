@extends('layouts.header')

@section('content')

@if(isset($employer) && $employer->status === 'registered')
    <div class="alert alert-success text-center">
        <h4>✅ すでに事業者登録が完了しています。</h4>
        <p>再度登録することはできません。登録内容の変更をご希望の場合は、サポートまでご連絡ください。</p>
        <a href="{{ route('login') }}" class="btn btn-primary mt-3">ログイン画面へ</a>
    </div>
@else
    <form action="{{ route('employer.completeRegistration', ['token' => $employer->verification_token]) }}" method="POST">
        @csrf
        <!-- Registration fields here -->
        <button type="submit" class="btn btn-success w-100 py-3 mt-3">
            {{ __('登録する') }}
        </button>
    </form>
@endif

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded-4">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h2 class="fw-bold">{{ __('事業者登録の完了') }}</h2>
                    <p class="lead mb-0">求人を掲載する前に、以下の情報をご入力ください。</p>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('employer.completeRegistration', ['token' => $employer->verification_token]) }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <!-- Business Type -->
                            <div class="col-md-12">
                                <label class="fw-bold">事業形態</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="business_type" value="法人" required>
                                    <label class="form-check-label">法人</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="business_type" value="個人事業主">
                                    <label class="form-check-label">個人事業主</label>
                                </div>
                            </div>

                            <!-- Company Name & Business Number -->
                            <div class="col-md-6">
                                <label class="fw-bold">法人名（または事業者名）</label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold">法人番号</label>
                                <input type="text" name="business_number" class="form-control" value="{{ old('business_number') }}" required>
                            </div>

                            <!-- Address Details -->
                            <div class="col-md-4">
                                <label class="fw-bold">郵便番号</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold">都道府県</label>
                                <input type="text" name="prefecture" class="form-control" value="{{ old('prefecture') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold">市区町村</label>
                                <input type="text" name="municipality" class="form-control" value="{{ old('municipality') }}" required>
                            </div>
                            <div class="col-md-8">
                                <label class="fw-bold">丁目・番地</label>
                                <input type="text" name="company_address" class="form-control" value="{{ old('company_address') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold">建物名・部屋番号（任意）</label>
                                <input type="text" name="building_name" class="form-control" value="{{ old('building_name') }}">
                            </div>

                            <!-- Contact -->
                            <div class="col-md-6">
                                <label class="fw-bold">ご連絡先電話番号</label>
                                <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone') }}" required>
                            </div>

                            <!-- Business Category -->
                            <div class="col-md-6">
                                <label class="fw-bold">主な事業内容</label>
                                <select name="business_category_id" class="form-select" required>
                                    <option value="">選択してください</option>
                                    @foreach ($businessCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Desired Job -->
                            <div class="col-md-6">
                                <label class="fw-bold">依頼したい業務内容</label>
                                <select name="desired_work_id" class="form-select" required>
                                    <option value="">選択してください</option>
                                    @foreach ($tasks as $task)
                                        <option value="{{ $task->id }}">{{ $task->task_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Challenges -->
                            <div class="col-md-6">
                                <label class="fw-bold">現在感じている課題・お困りごと</label>
                                <textarea name="challenges" class="form-control" rows="3" required>{{ old('challenges') }}</textarea>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success w-50 py-3 fw-bold">
                                {{ __('登録する') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
