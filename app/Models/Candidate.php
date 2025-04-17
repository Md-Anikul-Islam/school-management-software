<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'student_registration_number',
        'class_id',
        'section_id',
        'application_verified_by',
        'date_of_verification',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassName::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(SectionName::class, 'section_id');
    }

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }
}
