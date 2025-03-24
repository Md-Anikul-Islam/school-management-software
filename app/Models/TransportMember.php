<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'transport_id',
        'fare',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }
}
