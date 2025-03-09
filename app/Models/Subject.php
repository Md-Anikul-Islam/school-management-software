<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'class_id',
        'teacher_id',
        'type',
        'pass_mark',
        'final_mark',
        'subject_author',
        'name',
        'subject_code',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassName::class, 'class_id');
    }
}
