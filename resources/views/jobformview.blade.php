<!-- resources/views/jobformview.blade.php -->
@extends('layouts.header')

@section('content')
<div class="container">
    <h2>Job Creation Form</h2>

    <!-- Check if there's a success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Job creation form -->
    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Image Upload -->
        <div class="form-group">
            <label for="image">Upload Job Image (Optional)</label>
            <input type="file" class="form-control" id="image" name="image" onchange="previewImage()">
            
            <!-- Image Preview -->
            <div id="image-preview-container" class="mt-3" style="display: none;">
                <img id="image-preview" src="" alt="Image Preview" class="img-fluid rounded" style="max-width: 300px;">
            </div>
        </div>
        
        <!-- Employer Details -->
        <div class="form-group">
            <input type="hidden" class="form-control" id="employer_id" name="employer_id" value="{{ $employer->id }}" disabled>
        </div>

        <!-- Job Title -->
        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Job Description -->
        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Job Type -->
        <div class="form-group">
            <label for="job_type">Job Type</label>
            <select class="form-control" id="job_type" name="job_type" required>
                <option value="full" {{ old('job_type') == 'full' ? 'selected' : '' }}>Full-time</option>
                <option value="part" {{ old('job_type') == 'part' ? 'selected' : '' }}>Part-time</option>
                <option value="contract" {{ old('job_type') == 'contract' ? 'selected' : '' }}>Contract</option>
            </select>
            @error('job_type') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Working Days -->
        <div class="form-group">
            <label for="working_days">Working Days</label><br>

            <!-- Monday -->
            <input class="btn-check" type="checkbox" id="monday" name="working_days[]" value="monday" 
                {{ in_array('monday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="monday">Monday</label>

            <!-- Tuesday -->
            <input class="btn-check" type="checkbox" id="tuesday" name="working_days[]" value="tuesday" 
                {{ in_array('tuesday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="tuesday">Tuesday</label>

            <!-- Wednesday -->
            <input class="btn-check" type="checkbox" id="wednesday" name="working_days[]" value="wednesday" 
                {{ in_array('wednesday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="wednesday">Wednesday</label>

            <!-- Thursday -->
            <input class="btn-check" type="checkbox" id="thursday" name="working_days[]" value="thursday" 
                {{ in_array('thursday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="thursday">Thursday</label>

            <!-- Friday -->
            <input class="btn-check" type="checkbox" id="friday" name="working_days[]" value="friday" 
                {{ in_array('friday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="friday">Friday</label>

            <!-- Saturday -->
            <input class="btn-check" type="checkbox" id="saturday" name="working_days[]" value="saturday" 
                {{ in_array('saturday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="saturday">Saturday</label>

            <!-- Sunday -->
            <input class="btn-check" type="checkbox" id="sunday" name="working_days[]" value="sunday" 
                {{ in_array('sunday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="sunday">Sunday</label>


            @error('working_days') 
                <span class="text-danger">{{ $message }}</span> 
            @enderror
        </div>


        <!-- Working Hours -->
        <div class="form-group">
            <label for="working_hour">Working Hours</label>
            <input type="text" class="form-control" id="working_hour" name="working_hour" value="{{ old('working_hour') }}" required>
            @error('working_hour') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Location -->
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
            @error('location') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Salary -->
        <div class="form-group">
            <label for="salary">Salary</label>
            <input type="text" class="form-control" id="salary" name="salary" value="{{ old('salary') }}">
            @error('salary') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Required Skills -->
        <div class="form-group">
            <label for="required_skills">Required Skills</label>
            <textarea class="form-control" id="required_skills" name="required_skills">{{ old('required_skills') }}</textarea>
            @error('required_skills') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Visa Required -->
        <div class="form-group">
            <label for="visa_required">Visa Required</label>
            <input type="checkbox" id="visa_required" name="visa_required" value="1" {{ old('visa_required') ? 'checked' : '' }}>
            @error('visa_required') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Create Job</button>
    </form>
</div>
@endsection

<script>
    function previewImage() {
        const file = document.getElementById('image').files[0];
        const previewContainer = document.getElementById('image-preview-container');
        const imagePreview = document.getElementById('image-preview');

        // Only display the preview if a file was selected
        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                previewContainer.style.display = 'block'; // Show the image preview container
            };

            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none'; // Hide the preview container if no file is selected
        }
    }
</script>
