<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildCare extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'class_id',
        'student_id',
        'receiver_name',
        'phone',
        'drop_time',
        'receive_time',
        'comment',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function class()
    {
        return $this->belongsTo(ClassName::class, 'class_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
