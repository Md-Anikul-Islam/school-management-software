<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionName extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'capacity',
        'class_id',
        'teacher_id',
        'note',
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
        return $this->belongsTo(ClassName::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function examSchedules()
    {
        return $this->hasMany(ExamSchedule::class, 'section_id');
    }
}
