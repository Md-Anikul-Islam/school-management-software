<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guardian extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'father_name',
        'mother_name',
        'father_profession',
        'mother_profession',
        'email',
        'phone',
        'address',
        'photo',
        'username',
        'password',
        'status',
        'created_by',
        'updated_by',
        'school_id',
    ];

    public function students()
    {
        return $this->hasOne(Student::class);
    }
}
