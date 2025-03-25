<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'guardian_id',
        'admission_date',
        'dob',
        'gender',
        'blood_group_id',
        'religion',
        'email',
        'phone',
        'address',
        'city',
        'country_id',
        'class_id',
        'section_id',
        'group_id',
        'optional_subject',
        'reg_no',
        'roll',
        'photo',
        'extra_curricular_activities',
        'remarks',
        'username',
        'password',
        'status',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    public function bloodGroup()
    {
        return $this->belongsTo(BloodGroup::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassName::class);
    }

    public function section()
    {
        return $this->belongsTo(SectionName::class);
    }

    public function group()
    {
        return $this->belongsTo(GroupName::class);
    }

    public function optionalSubject()
    {
        return $this->belongsTo(Subject::class, 'code', 'optional_subject');
    }

    public function transportMembers()
    {
        return $this->hasMany(TransportMember::class);
    }

    public function hostelMembers()
    {
        return $this->hasMany(HostelMember::class);
    }
}

