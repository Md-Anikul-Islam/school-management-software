<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassName extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'class_numeric',
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

    public function section()
    {
        return $this->hasMany(SectionName::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function examSchedules()
    {
        return $this->hasMany(ExamSchedule::class, 'class_id');
    }

    public function childCare()
    {
        return $this->hasMany(ChildCare::class, 'class_id');
    }

    public function ebooks()
    {
        return $this->hasMany(Ebooks::class, 'class_id');
    }
}
