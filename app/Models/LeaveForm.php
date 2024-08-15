<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveForm extends Model
{
    use HasFactory;

    protected $table = 'leaveforms';

    protected $fillable = [
        'CodeLeaveForm',
        'IDMemberLeave',
        'TimeLeaveStart',
        'TimeLeaveEnd',
        'Reason',
        'Note',
        'IDMemberReplace',
        'IDMemberCreated',
        'DateCreated',
    ];

    public function memberLeave()
    {
        return $this->belongsTo(User::class, 'IDMemberLeave');
    }

    public function memberReplace()
    {
        return $this->belongsTo(User::class, 'IDMemberReplace');
    }

    public function memberCreated()
    {
        return $this->belongsTo(User::class, 'IDMemberCreated');
    }

    public function approvelfs()
    {
        return $this->hasMany(ApproveLf::class, 'IDLeaveForms');
    }
}
