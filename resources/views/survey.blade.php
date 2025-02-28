@extends('layouts.header')

@section('content')
<div class="container">
    <h2>Jobseeker Survey</h2>
    <form method="POST" action="{{ route('survey.submit') }}">
        @csrf
        @foreach($surveys as $survey)
            <div class="mb-4">
                <p><strong>{{ $survey->question_text }}</strong></p>
                @foreach(['a', 'b', 'c', 'd'] as $option)
                    <input type="radio" name="responses[{{ $survey->id }}]" value="{{ $option }}" required> 
                    {{ $survey['option_' . $option] }}<br>
                @endforeach
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
