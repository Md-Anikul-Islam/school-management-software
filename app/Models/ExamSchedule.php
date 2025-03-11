<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamSchedule extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'class_id',
        'exam_id',
        'section_id',
        'subject_id',
        'date',
        'time_from',
        'time_to',
        'room_no',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function class()
    {
        return $this->belongsTo(ClassName::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(SectionName::class, 'section_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}
