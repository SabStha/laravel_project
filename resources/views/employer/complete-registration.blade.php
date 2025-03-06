@extends('layouts.header')

@section('content')

@if(isset($employer) && $employer->status === 'registered')
    <div class="alert alert-success text-center">
        <h4>✅ You have already registered your business.</h4>
        <p>You cannot register again. If you need to update your details, please contact support.</p>
        <a href="{{ route('login') }}" class="btn btn-primary mt-3">Go to Login</a>
    </div>
@else
    <form action="{{ route('employer.completeRegistration', ['token' => $employer->verification_token]) }}" method="POST">
        @csrf
        <!-- Registration fields here -->
        <button type="submit" class="btn btn-success w-100 py-3 mt-3">
            {{ __('Register') }}
        </button>
    </form>
@endif




<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded-4">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h2 class="fw-bold">{{ __('Complete Your Business Registration') }}</h2>
                    <p class="lead mb-0">Please fill in all details before posting jobs.</p>
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
                                <label class="fw-bold">法人名</label>
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
                                <label class="fw-bold">住所</label>
                                <input type="text" name="company_address" class="form-control" value="{{ old('company_address') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold">建物名</label>
                                <input type="text" name="building_name" class="form-control" value="{{ old('building_name') }}">
                            </div>

                            <!-- Contact -->
                            <div class="col-md-6">
                                <label class="fw-bold">連絡先</label>
                                <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone') }}" required>
                            </div>

                            <!-- Business Category Selection -->
                            <div class="col-md-6">
                                <label class="fw-bold">事業者の主な業務内容</label>
                                <select name="business_category_id" class="form-select" required>
                                    <option value="">選択してください</option>
                                    @foreach ($businessCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Desired Job Selection -->
                            <div class="col-md-6">
                                <label class="fw-bold">任せたい仕事</label>
                                <select name="desired_work_id" class="form-select" required>
                                    <option value="">選択してください</option>
                                    @foreach ($tasks as $task)
                                        <option value="{{ $task->id }}">{{ $task->task_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Business Challenges -->
                            <div class="col-md-6">
                                <label class="fw-bold">現在の課題感</label>
                                <textarea name="challenges" class="form-control" rows="3" required>{{ old('challenges') }}</textarea>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success w-50 py-3 fw-bold">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
