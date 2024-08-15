<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobRequestFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jobRequestForm;
    public $userCreated;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobRequestForm, $userCreated)
    {
        $this->jobRequestForm = $jobRequestForm;
        $this->userCreated = $userCreated;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.JRF.mailJRF')
                    ->with([
                        'code' => $this->jobRequestForm['CodeJobRequestForms'],
                        'content' => $this->jobRequestForm['Content'],
                        'timeFinish' => $this->jobRequestForm['TimeFinish'],
                    ])
                    ->subject('Thông báo Phiếu Yêu Cầu Công Việc Mới');
    }
}
