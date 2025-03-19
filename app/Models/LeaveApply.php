<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveApply extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'role_id',
        'application_to',
        'leave_category_id',
        'start_date',
        'end_date',
        'reason',
        'attachment',
        'status',
        'school_id',
        'created_by',
        'updated_by',
    ];
//
//    public function role()
//    {
//        return $this->belongsTo(Role::class);
//    }

    public function leaveCategory()
    {
        return $this->belongsTo(LeaveCategory::class);
    }

    public function applicationTo()
    {
        return $this->belongsTo(User::class, 'application_to');
    }

    public function leaveApplication()
    {
        return $this->hasMany(LeaveApplication::class);
    }
}
