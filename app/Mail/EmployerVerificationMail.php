<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployerVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $verificationLink;

    public function __construct($user, $password, $verificationLink)
    {
        $this->user = $user;
        $this->password = $password;
        $this->verificationLink = $verificationLink;
    }

    public function build()
    {
        return $this->subject('Complete Your Employer Registration')
                    ->view('emails.employer_verification')
                    ->with([
                        'name' => $this->user->name,
                        'password' => $this->password,
                        'verificationLink' => $this->verificationLink,
                    ]);
    }
}
