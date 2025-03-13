<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HostelCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [
        'hostel_id',
        'class_type',
        'hostel_fee',
        'note',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function hostelMembers()
    {
        return $this->hasMany(HostelMember::class);
    }
}
