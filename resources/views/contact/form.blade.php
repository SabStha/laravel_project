@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-3">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h3>{{ __('お問い合わせ') }}</h3> <!-- Contact Us -->
                    <p class="lead">ご質問やお問い合わせはこちらから</p> <!-- For inquiries and questions -->
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <p class="text-success text-center">{{ session('status') }}</p>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf

                        <!-- Name -->
                        <div class="form-group mb-4">
                            <label for="name" class="form-label">{{ __('氏名') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">{{ __('メールアドレス') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div class="form-group mb-4">
                            <label for="message" class="form-label">{{ __('問い合わせ内容') }}</label>
                            <textarea id="message" class="form-control @error('message') is-invalid @enderror" name="message" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 rounded-pill">
                                {{ __('送信') }} <!-- Submit -->
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
