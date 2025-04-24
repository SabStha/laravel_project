@extends('layouts.header')

@section('content')
<div class="container">
    
    <h2 class="text-center my-4">全ての求職者</h2>      

    <div class="row">
        @foreach($jobseekers as $jobseeker)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                
                <div class="card shadow-lg rounded-3">
                    <div class="card-body text-center">
                       
                        <img src="{{ $jobseeker->image ? asset('storage/'.$jobseeker->image) : asset('images/default-profile.png') }}" 
                             class="rounded-circle mb-3 img-fluid" style="max-width: 80px; height: auto;" alt="Profile Image">

                        
                        <h5 class="card-title">{{ $jobseeker->user->name }}</h5>
                        
                       
                        <p class="text-muted">{{ $jobseeker->user->email }}</p>

                       
                        <a href="{{ route('chat.start', $jobseeker->user->id) }}" class="btn btn-info btn-sm w-100 rounded-pill">
                            メッセージ
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
