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
                    <h3>{{ __('Evaluate Jobseeker') }}</h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    

                   
                    
                        <p class="text-muted">{{ __('No evaluations yet. Please evaluate below.') }}</p>
                    @endif

                    <hr>

                    <h4 class="mb-3">{{ __('Submit a New Evaluation') }}</h4>

                    <form method="POST" action="{{ route('operator.submitEvaluation', ['user_id' => $jobseeker->user_id]) }}">
                        @csrf
                        <input type="hidden" name="jobseeker_id" value="{{ $jobseeker->id }}">

                        @foreach ($evaluation_axes as $axis)
                        <div class="mb-3">
                            <label class="form-label">{{ __($axis->name) }}</label>
                            <div class="rating-container">
                                @for ($i = 1; $i <= 5; $i++)
                                    @php
                                        $previousRating = $existingEvaluations->where('axis_id', $axis->id)->first()->rating ?? null;
                                        $highlightClass = ($previousRating == $i) ? 'highlighted' : '';
                                    @endphp
                    
                                    <input type="radio" id="axis_{{ $axis->id }}_{{ $i }}" 
                                           name="ratings[{{ $axis->id }}]" 
                                           value="{{ $i }}" 
                                           {{ $previousRating == $i ? 'checked' : '' }}>
                                    <label for="axis_{{ $axis->id }}_{{ $i }}" class="{{ $highlightClass }}">{{ $i }}</label>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                    


                        <div class="text-center">
                            <button type="submit" class="btn btn-success">{{ __('Submit Evaluation') }}</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('operator.viewEvaluations') }}" class="btn btn-secondary">
                            {{ __('Back to Evaluations') }}
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
        justify-content: center; /* Center-align ratings */
        gap: 10px;
        align-items: center;
        padding: 10px 0;
    }

    .rating-container input[type="radio"] {
        display: none; /* Hide the default radio button */
    }

    /* Style the label to look like a clickable button */
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

    /* Change the color when hovered */
    .rating-container label:hover {
        background-color: #e0e0e0;
        border-color: #b5b5b5;
    }

    /* Selected (Checked) Radio Button */
    .rating-container input[type="radio"]:checked + label {
        background-color: #28a745; /* Green for selection */
        color: white;
        border-color: #1e7e34;
        box-shadow: 0 0 10px rgba(0, 128, 0, 0.5);
        transform: scale(1.1); /* Slight pop effect */
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .rating-container {
            flex-wrap: wrap;
        }

        .rating-container label {
            padding: 10px 14px;
            font-size: 14px;
            min-width: 40px;
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

/* Style selected rating */
.rating-container input[type="radio"]:checked + label {
    background-color: #28a745; /* Green */
    color: white;
    border-color: #1e7e34;
    box-shadow: 0 0 10px rgba(0, 128, 0, 0.5);
}

/* Highlight previous ratings */
.rating-container .highlighted {
    background-color: #ffcc00 !important; /* Yellow for previous ratings */
    color: black !important;
    font-weight: bold;
    border-color: #ff9900;
    box-shadow: 0 0 10px rgba(255, 165, 0, 0.8);
}

    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let selectedRatings = document.querySelectorAll(".rating-container input:checked");
    
        selectedRatings.forEach(radio => {
            let label = radio.nextElementSibling;
            label.style.backgroundColor = "#28a745"; // Green background for preselected
            label.style.color = "white"; // White text for contrast
            label.style.borderColor = "#1e7e34";
            label.style.boxShadow = "0 0 10px rgba(0, 128, 0, 0.5)";
            label.style.transform = "scale(1.1)";
        });
    });
    </script>
    

@endsection
