@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Display Jobseeker's Name at the Very Top -->
            <div class="text-center mb-4">
                <h1><span class="text-primary">{{ $jobseeker->name }}</span></h1>
            </div>

            <div class="card shadow-lg rounded-3">
                <div class="card-header text-center bg-warning text-white py-4">
                    <h3>{{ __('求職者を評価する') }}</h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        <p class="text-muted">{{ __('まだ評価がありません。以下から評価を行ってください。') }}</p>
                    @endif

                    <hr>

                    <h4 class="mb-3">{{ __('新しい評価を送信') }}</h4>

                    <form method="POST" action="{{ route('operator.submitEvaluation', ['user_id' => $jobseeker->user_id]) }}">
                        @csrf
                        <input type="hidden" name="jobseeker_id" value="{{ $jobseeker->id }}">

                        @foreach ($evaluation_axes as $axis)
                            <div class="mb-3">
                                <label class="form-label">{{ __($axis->name) }}</label>
                                <div class="rating-container">
                                    @php
                                        // Match using axis_name instead of axis_id
                                        $previousRating = optional($existingEvaluations->firstWhere('axis_name', $axis->name))->rating;
                                    @endphp
                        
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" id="axis_{{ $axis->id }}_{{ $i }}" 
                                            name="ratings[{{ $axis->id }}]" 
                                            value="{{ $i }}" 
                                            {{ $previousRating == $i ? 'checked' : '' }}>
                                        <label for="axis_{{ $axis->id }}_{{ $i }}" class="{{ $previousRating == $i ? 'highlighted' : '' }}">{{ $i }}</label>
                                    @endfor
                                </div>
                            </div>
                        @endforeach

                        <div class="text-center">
                            <button type="submit" class="btn btn-success">{{ __('評価を送信') }}</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('operator.viewEvaluations') }}" class="btn btn-secondary">
                            {{ __('評価一覧へ戻る') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS Styling -->
<style>
    .rating-container {
    display: flex;
    justify-content: center;
    gap: 10px;
    align-items: center;
    padding: 10px 0;
}

.rating-container input[type="radio"] {
    display: none;
}

.rating-container label {
    background-color: #f1f1f1;
    padding: 12px 18px;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid #ccc;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    min-width: 50px;
    transition: all 0.3s ease-in-out;
}

.rating-container label:hover {
    background-color: #e0e0e0;
    border-color: #b5b5b5;
}

.rating-container input[type="radio"]:checked + label {
    background-color: #28a745;
    color: white;
    border-color: #1e7e34;
    box-shadow: 0 0 10px rgba(0, 128, 0, 0.5);
    transform: scale(1.1);
}

.rating-container label.highlighted {
    background-color: #ffcc00 !important;
    color: black !important;
    font-weight: bold;
    border-color: #ff9900;
    box-shadow: 0 0 10px rgba(255, 165, 0, 0.8);
}

@media (max-width: 768px) {
    .rating-container {
        flex-wrap: wrap;
    }

    .rating-container label {
        padding: 10px 14px;
        font-size: 14px;
        min-width: 40px;
    }
}
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Highlighting script loaded");
        let highlightedRatings = document.querySelectorAll(".rating-container .highlighted");
        
        highlightedRatings.forEach(label => {
            label.style.backgroundColor = "#ffcc00";
            label.style.color = "black";
            label.style.borderColor = "#ff9900";
            label.style.boxShadow = "0 0 10px rgba(255, 165, 0, 0.8)";
        });
    
        let ratingInputs = document.querySelectorAll(".rating-container input[type='radio']");
        
        ratingInputs.forEach(input => {
            input.addEventListener("change", function () {
                let allLabels = this.closest(".rating-container").querySelectorAll("label");
                
                allLabels.forEach(label => {
                    label.classList.remove("highlighted");
                    label.style.backgroundColor = "#f1f1f1";
                    label.style.color = "black";
                    label.style.borderColor = "#ccc";
                    label.style.boxShadow = "none";
                });
    
                let selectedLabel = this.nextElementSibling;
                selectedLabel.style.backgroundColor = "#28a745";
                selectedLabel.style.color = "white";
                selectedLabel.style.borderColor = "#1e7e34";
                selectedLabel.style.boxShadow = "0 0 10px rgba(0, 128, 0, 0.5)";
                selectedLabel.style.transform = "scale(1.1)";
            });
        });
    });
</script>

@endsection
