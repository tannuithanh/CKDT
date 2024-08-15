<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproveJsf extends Model
{
    use HasFactory;

    protected $table = 'approvejsf';

    protected $fillable = [
        'IDJobRequestForms',
        'IDMember',
        'TimeStamp',
        'Status',
        'No',
    ];

    public function jobRequestForm()
    {
        return $this->belongsTo(JobRequestForm::class, 'IDJobRequestForms');
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'IDMember');
    }
}
