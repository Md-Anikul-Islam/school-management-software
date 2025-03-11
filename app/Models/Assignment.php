<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'class_id',
        'section_id',
        'subject_id',
        'file',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function class()
    {
        return $this->belongsTo(ClassName::class, 'class_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(SectionName::class, 'section_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
