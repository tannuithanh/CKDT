<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobRequestFormMailNew extends Mailable
{
    use Queueable, SerializesModels;

    public $jobRequestForm;
    public $messageContent;
    public $userCreatedJSF;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobRequestForm, $messageContent, $userCreatedJSF)
    {
        $this->jobRequestForm = $jobRequestForm;
        $this->messageContent = $messageContent;
        $this->userCreatedJSF = $userCreatedJSF;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.JRF.mailJRFNew')
                    ->with([
                        'name' => $this->messageContent,
                        'code' => $this->jobRequestForm['CodeJobRequestForms'],
                        'userCreatedJSF' => $this->userCreatedJSF
                    ])
                    ->subject('Thông báo phiếu yêu cầu công việc');
    }
}
