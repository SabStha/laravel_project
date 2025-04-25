@extends('layouts.header')

@section('content')
<div class="d-flex justify-content-between align-items-center my-3">
    <a href="{{ route('operator.dashboard') }}" class="btn btn-outline-dark btn-lg">⬅ Back</a>
</div>

<div class="container text-center mb-4">
    <h2 class="fw-bold">🔍 Jobseeker Management</h2>
    <p class="lead text-muted">View, search, and manage jobseeker details efficiently.</p>
</div>

<div class="container">
    @php
        $hasAdvancedFilters = request()->filled('name') || request()->filled('email') || collect(request('surveys'))->filter()->isNotEmpty();
    @endphp

    <form id="filterForm" class="row g-3 mb-3" method="GET" action="{{ route('operator.viewJobseekers') }}">
        {{-- ✅ Basic Filters --}}
        <div class="col-md-3">
            <label class="form-label">⚧ 性別</label>
            <select name="gender" class="form-control">
                <option value="">All</option>
                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">🎓 卒業年</label>
            <select name="graduation_year" class="form-control">
                <option value="">Select</option>
                @foreach($graduationDates as $year)
                    <option value="{{ $year }}" {{ request('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">🏫 学校</label>
            <select name="school" class="form-control">
                <option value="">Select</option>
                @foreach($schools as $school)
                    <option value="{{ $school }}" {{ request('school') == $school ? 'selected' : '' }}>{{ $school }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">🌎 国籍</label>
            <select name="citizenship" class="form-control">
                <option value="">Select</option>
                @foreach($citizenships as $citizenship)
                    <option value="{{ $citizenship }}" {{ request('citizenship') == $citizenship ? 'selected' : '' }}>{{ $citizenship }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">📜 JLPT</label>
            <select name="jlpt" class="form-control">
                <option value="">Select</option>
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
                <input type="text" name="name" class="form-control" placeholder="Enter jobseeker's name" value="{{ request('name') }}">
            </div>

            <!-- 📧 メール -->
            <div class="col-md-6">
                <label class="form-label">📧 メール</label>
                <input type="text" name="email" class="form-control" placeholder="Enter email address" value="{{ request('email') }}">
            </div>
        </div>
    </div>
</div>



        {{-- 🔍 Submit --}}
        <div class="col-md-12 text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">🔎 Search</button>
        </div>
    </form>

    <!-- 📋 Jobseeker Grid -->
    <div id="jobseekerContainer" class="row g-4">
        @include('jobseeker_grid_partial', ['jobseekers' => $jobseekers])
    </div>

    @if($jobseekers->isEmpty())
        <p class="text-center text-danger">No jobseekers found.</p>
    @endif
</div>
@endsection
