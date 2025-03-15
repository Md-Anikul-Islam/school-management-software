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
        'created_by',
        'updated_by',
    ];

    public function examSchedules()
    {
        return $this->hasMany(ExamSchedule::class, 'exam_id');
    }
}
