<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproveLf extends Model
{
    use HasFactory;

    protected $table = 'approvelf';

    protected $fillable = [
        'IDLeaveForms',
        'IDMember',
        'TimeStamp',
        'Status',
        'No',
        'Note',
    ];

    public function leaveForm()
    {
        return $this->belongsTo(LeaveForm::class, 'IDLeaveForms');
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'IDMember');
    }
}
