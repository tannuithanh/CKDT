<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $leaveForm;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($leaveForm)
    {
        $this->leaveForm = $leaveForm;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.LF.mailLF')
                    ->subject('Trình duyệt giấy xin phép')
                    ->with(['leaveForm' => $this->leaveForm]);
    }
}
