<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'designation',
        'dob',
        'gender',
        'religion',
        'email',
        'phone',
        'address',
        'joining_date',
        'photo',
        'username',
        'password',
        'routine',
        'status',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function subject()
    {
        return $this->hasMany(Subject::class);
    }

    public function section()
    {
        return $this->hasMany(SectionName::class);
    }

    public function class()
    {
        return $this->hasMany(ClassName::class);
    }
}
