<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveFormMailNew extends Mailable
{
    use Queueable, SerializesModels;

    public $fullName;
    public $name;
    public $loaiphieu;
    public $codeLeaveForm;
    public $member;
    public $detailUrl;
    public $nameDept;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nameDept,$fullName, $name, $loaiphieu, $codeLeaveForm, $member, $detailUrl){
        $this->nameDept = $nameDept;
        $this->fullName = $fullName;
        $this->fullName = $fullName;
        $this->name = $name;
        $this->loaiphieu = $loaiphieu;
        $this->codeLeaveForm = $codeLeaveForm;
        $this->member = $member;
        $this->detailUrl = $detailUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.mailForms')
                    ->subject('Thông báo phê duyệt giấy xin phép');
    }
}
