<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mark extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'class_id',
        'exam_id',
        'section_id',
        'subject_id',
        'student_id',
        'exam_mark',
        'attendance',
        'class_test',
        'assignment',
        'created_by',
        'updated_by',
    ];

    public function examSchedules()
    {
        return $this->hasMany(ExamSchedule::class, 'exam_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function section()
    {
        return $this->belongsTo(SectionName::class, 'section_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function className()
    {
        return $this->belongsTo(ClassName::class, 'class_id');
    }
}
