<style>
    /* Elegant Font */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fdf7e4; /* Soft pastel background */
    }

    /* Card Styling */
    .jobseeker-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: all 0.3s ease-in-out;
        height: 100%;
        position: relative; /* Required for button positioning */
    }

    /* Profile Image */
    .jobseeker-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #eee;
    }

    /* Title */
    .jobseeker-name {
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        color: #333;
    }

    /* Jobseeker Details */
    .jobseeker-info p {
        font-size: 14px;
        margin-bottom: 6px;
        color: #555;
    }

    /* Survey Status */
    .survey-completed {
        font-weight: bold;
        color: #28a745;
    }

    .survey-not-completed {
        font-weight: bold;
        color: #dc3545;
    }

    /* Chat Button */
    .chat-button {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #ff4081; /* Pink color */
        color: white;
        border: none;
        padding: 8px 12px;
        font-size: 14px;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .chat-button:hover {
        background-color: #e91e63; /* Darker pink */
    }

    /* Pagination */
    .pagination {
        margin-top: 20px;
    }
</style>

<div class="row g-4">
    @foreach($jobseekers as $jobseeker)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
            <div class="jobseeker-card w-100">
                
            <a href="{{ route('chat.start', $jobseeker->user->id) }}" class="btn btn-info w-100 rounded-pill">
                            Chat
                        </a>
                <div class="text-center">
                    <img src="{{ $jobseeker->image && file_exists(public_path('images/' . $jobseeker->image)) ? asset('images/' . $jobseeker->image) : asset('images/placeholder-shadow.png') }}" 
                        class="jobseeker-image mb-3" alt="Profile Image">
                </div>

                <h5 class="jobseeker-name">{{ ucfirst($jobseeker->user->name) }}</h5>

                <div class="jobseeker-info">
                    <p><strong>🎓 School:</strong> {{ $jobseeker->school ?? 'N/A' }}</p>
                    <p><strong>📧 Email:</strong> {{ $jobseeker->user->email ?? 'N/A' }}</p>
                    <p><strong>🌎 Citizenship:</strong> {{ $jobseeker->citizenship ?? 'N/A' }}</p>
                    <p><strong>🎓 Graduation:</strong> {{ $jobseeker->expected_to_graduate ?? 'N/A' }}</p>
                    <p><strong>⚧ Gender:</strong> {{ ucfirst($jobseeker->gender ?? 'N/A') }}</p>
                    <p><strong>🎂 Age:</strong> 
                        {{ $jobseeker->birthday ? \Carbon\Carbon::parse($jobseeker->birthday)->age : 'N/A' }}
                    </p>
                    <p><strong>📜 JLPT:</strong> {{ $jobseeker->jlpt ?? 'N/A' }}</p>
                    <p><strong>💰 Wage:</strong> ¥{{ number_format($jobseeker->wage) ?? 'N/A' }}</p>
                </div>

                <p class="{{ $jobseeker->survey_completed ? 'survey-completed' : 'survey-not-completed' }}">
                    {{ $jobseeker->survey_completed ? '✅ Survey Completed' : '❌ Survey Not Completed' }}
                </p>

                <div class="text-center">
                    <a href="{{ route('jobseekers.show', $jobseeker->id) }}" class="fw-bold text-primary">
                        View Profile
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $jobseekers->links('pagination::bootstrap-4') }}
</div>
