<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRequestForm extends Model
{
    use HasFactory;

    protected $table = 'jobrequestforms';

    protected $fillable = [
        'CodeJobRequestForms',
        'IDDepartmentRequest',
        'IDDepartmentPerforming',
        'Content',
        'TimeFinish',
        'Note',
        'DateCreate',
    ];

    public function departmentRequest()
    {
        return $this->belongsTo(Department::class, 'IDDepartmentRequest');
    }

    public function departmentPerforming()
    {
        return $this->belongsTo(Department::class, 'IDDepartmentPerforming');
    }

    public function approvejsfs()
    {
        return $this->hasMany(ApproveJsf::class, 'IDJobRequestForms');
    }
}
