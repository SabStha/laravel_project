<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class JobseekerDoesNotMeetRequirements extends Notification
{
    public $jobseekerId, $jobId;

    public function __construct($jobseekerId, $jobId)
    {
        $this->jobseekerId = $jobseekerId;
        $this->jobId = $jobId;
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "A jobseeker applied but does not meet the minimum requirements for your job posting.",
            'job_id' => $this->jobId,
            'jobseeker_id' => $this->jobseekerId
        ];
    }
}
