@extends('layouts.header')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded-4">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h2 class="fw-bold">{{ __('Edit Business Registration') }}</h2>
                    <p class="lead mb-0">Update your business details below.</p>
                </div>

                <div class="card-body">
                    <form action="{{ route('employer.updateRegistration') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <!-- Business Type -->
                            <div class="col-md-12">
                                <label class="fw-bold">事業形態</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="business_type" value="法人"
                                        {{ $user->employer->business_type == '法人' ? 'checked' : '' }} required>
                                    <label class="form-check-label">法人</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="business_type" value="個人事業主"
                                        {{ $user->employer->business_type == '個人事業主' ? 'checked' : '' }}>
                                    <label class="form-check-label">個人事業主</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold">法人名</label>
                                <input type="text" name="company_name" class="form-control"
                                    value="{{ $user->employer->company_name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold">法人番号</label>
                                <input type="text" name="business_number" class="form-control"
                                    value="{{ $user->employer->business_number }}" required>
                            </div>

                            <!-- Address Details -->
                            <div class="col-md-4">
                                <label class="fw-bold">郵便番号</label>
                                <input type="text" name="postal_code" class="form-control"
                                    value="{{ $user->employer->postal_code }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold">都道府県</label>
                                <input type="text" name="prefecture" class="form-control"
                                    value="{{ $user->employer->prefecture }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold">市区町村</label>
                                <input type="text" name="municipality" class="form-control"
                                    value="{{ $user->employer->municipality }}" required>
                            </div>

                            <div class="col-md-8">
                                <label class="fw-bold">住所</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ $user->employer->address }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="fw-bold">建物名</label>
                                <input type="text" name="building_name" class="form-control"
                                    value="{{ $user->employer->building_name }}">
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold">連絡先</label>
                                <input type="text" name="contact_phone" class="form-control"
                                    value="{{ $user->employer->contact_phone }}" required>
                            </div>

                            <!-- Business Category Selection -->
                            <div class="col-md-6">
                                <label class="fw-bold">事業者の主な業務内容</label>
                                <select name="business_category_id" class="form-select" required>
                                    @foreach ($businessCategories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $user->employer->business_category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Challenges -->
                            <div class="col-md-12">
                                <label class="fw-bold">現在の課題感</label>
                                <textarea name="challenges" class="form-control" rows="3"
                                    required>{{ $user->employer->challenges }}</textarea>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success w-50 py-3 fw-bold">
                                {{ __('Update Registration') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
