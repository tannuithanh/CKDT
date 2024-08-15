<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'MSNV', 'FullName', 'Pass', 'MailAddress', 'PositionDetail', 'Division',
        'IDPosition', 'IDDepartment', 'Avatar', 'Signature', 'Admin'
    ];

    protected $hidden = [
        'Pass',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPassAttribute($password)
    {
        $this->attributes['Pass'] = bcrypt($password);
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'IDPosition');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'IDDepartment');
    }
}
