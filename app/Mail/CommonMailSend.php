<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommonMailSend extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $email_type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $email_type)
    {
        $this->user = $user;
        $this->email_type = $email_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [];
        switch ($this->email_type) {
            case ('welcome_user_mail'):
                $data = $this->welcomeUserContent($this->user);
                break;
            case ('change_user_password_mail'):
                $data = $this->changePasswordContent($this->user);
                break;
        }

        return $this->subject($data['subject'])
            ->view('components.mails.common_mail')->with($data);
    }

    public function welcomeUserContent($user)
    {
        return [
            'title' => 'Welcome to FIMA',
            'description' => 'Hello ' . $user->name . ',

            WELCOME to FIMA.

            Thanks for joining to our website. Hope you are enjoying our products with so much varieties.
            
            Thank you.',
            'subject' => 'FIMA : Welcome to FIMA'
        ];
    }

    public function changePasswordContent($user)
    {
        return [
            'title' => 'Password Changed',
            'description' => 'Hello ' . $user->name . ',

            You have successfully changed your FIMA password. Please Login again with your new password.
            
            Thank you.',
            'subject' => 'FIMA : Password changed'
        ];
    }
}
