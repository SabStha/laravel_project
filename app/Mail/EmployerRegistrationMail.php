<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployerRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Complete Your Employer Registration')
                    ->view('emails.employer_registration')
                    ->with([
                        'name' => $this->user->name,
                        'url' => route('employer.completeRegistrationForm', $this->token),
                    ]);
    }
}
