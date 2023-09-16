<?php

namespace App\Mail;

use App\Models\OtpVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp_verification;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$otp_verification)
    {
        $this->otp_verification = $otp_verification;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $data = [];
        switch ($this->otp_verification->request_for == OtpVerification::REQUEST_FOR_RESET_PASS) {
            case (OtpVerification::REQUEST_FOR_RESET_PASS):
                $data = $this->prepareData($this->user, $this->otp_verification);
                break;
        }

        return $this->subject($data['subject'])
            ->view('components.mails.common_mail')->with($data);
    }

    public function prepareData($user, $otp_verification)
    {
        return [
            'title' => 'Reset Password OTP',
            'description' => 'Hello ' . $user->name . ',

            Your OTP is : '.$otp_verification->otp.'
            
            Thank you.',
            'subject' => 'FIMA : Generate OTP for reset password'
        ];
    }
}
