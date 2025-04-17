<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibraryMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'library_id',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function library()
    {
        return $this->belongsTo(Library::class);
    }
}
