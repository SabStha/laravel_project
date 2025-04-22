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
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
            <label for="title">職種</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Job Description -->
        <div class="form-group">
            <label for="description">職務内容</label>
            <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Job Type -->
        <div class="form-group">
            <label for="job_type">仕事の種類</label>
            <select class="form-control" id="job_type" name="job_type" required>
                <option value="full" {{ old('job_type') == 'full' ? 'selected' : '' }}>正社員（</option>
                <option value="part" {{ old('job_type') == 'part' ? 'selected' : '' }}>アルバイト </option>
                <option value="contract" {{ old('job_type') == 'contract' ? 'selected' : '' }}>契約社員</option>
            </select>
            @error('job_type') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Working Days -->
        <div class="form-group">
            <label for="working_days">勤務日</label><br>

            <!-- Monday -->
            <input class="btn-check" type="checkbox" id="monday" name="working_days[]" value="monday" 
                {{ in_array('monday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="monday">月曜日</label>

            <!-- Tuesday -->
            <input class="btn-check" type="checkbox" id="tuesday" name="working_days[]" value="tuesday" 
                {{ in_array('tuesday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="tuesday">火曜日</label>

            <!-- Wednesday -->
            <input class="btn-check" type="checkbox" id="wednesday" name="working_days[]" value="wednesday" 
                {{ in_array('wednesday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="wednesday">水曜日</label>

            <!-- Thursday -->
            <input class="btn-check" type="checkbox" id="thursday" name="working_days[]" value="thursday" 
                {{ in_array('thursday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="thursday">木曜日</label>

            <!-- Friday -->
            <input class="btn-check" type="checkbox" id="friday" name="working_days[]" value="friday" 
                {{ in_array('friday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="friday">金曜日</label>

            <!-- Saturday -->
            <input class="btn-check" type="checkbox" id="saturday" name="working_days[]" value="saturday" 
                {{ in_array('saturday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="saturday">土曜日</label>

            <!-- Sunday -->
            <input class="btn-check" type="checkbox" id="sunday" name="working_days[]" value="sunday" 
                {{ in_array('sunday', old('working_days', [])) ? 'checked' : '' }} autocomplete="off">
            <label class="btn btn-outline-primary" for="sunday">日曜日</label>


            @error('working_days') 
                <span class="text-danger">{{ $message }}</span> 
            @enderror
        </div>


        <!-- Working Hours -->
        <div class="form-group">
            <label for="working_hour"> 勤務時間</label>
            <input type="text" class="form-control" id="working_hour" name="working_hour" value="{{ old('working_hour') }}" required>
            @error('working_hour') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Location -->
        <div class="form-group">
            <label for="location">住所</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
            @error('location') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Salary -->
        <div class="form-group">
            <label for="salary">給料</label>
            <input type="text" class="form-control" id="salary" name="salary" value="{{ old('salary') }}">
            @error('salary') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Required Skills -->
        <div class="form-group">
            <label for="required_skills"> 必要なスキル</label>
            <textarea class="form-control" id="required_skills" name="required_skills">{{ old('required_skills') }}</textarea>
            @error('required_skills') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Visa Required -->
        <div class="form-group">
            <label for="visa_required"> ビザが必要 </label>
            <input type="checkbox" id="visa_required" name="visa_required" value="1" {{ old('visa_required') ? 'checked' : '' }}>
            @error('visa_required') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <!-- resources/views/jobformview.blade.php -->
        <div class="form-group">
            <label><strong>評価基準</strong></label><br>
            @foreach(App\Models\EvaluationAxis::all() as $axis)
                <div class="mb-2">
                    <label>{{ $axis->name }}</label>
                    <select class="form-control" id="evaluation_axis_{{ $axis->id }}" name="evaluation[{{ $axis->id }}]" required>
                        <option value="">評価を選択</option>
                        @for($rating = 1; $rating <= 5; $rating++)
                            <option value="{{ $rating }}" {{ old('evaluation.'.$axis->id) == $rating ? 'selected' : '' }}>
                                {{ $rating }}
                            </option>
                        @endfor
                    </select>
                    @error('evaluation.'.$axis->id)
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach
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
