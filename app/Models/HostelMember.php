<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HostelMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'hostel_id',
        'hostel_category_id',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function hostelCategory()
    {
        return $this->belongsTo(HostelCategory::class);
    }
}
