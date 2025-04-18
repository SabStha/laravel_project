<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class JobApplicationNotMatchingRequirements extends Notification
{
    public $jobId;

    public function __construct($jobId)
    {
        $this->jobId = $jobId;
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "You applied for a job but do not meet the required qualifications.",
            'job_id' => $this->jobId
        ];
    }
}
