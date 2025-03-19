<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveAssign extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'role_id',
        'leave_category_id',
        'number_of_days',
        'school_id',
        'created_by',
        'updated_by',
    ];

//    public function role()
//    {
//        return $this->belongsTo(Role::class);
//    }

    public function leaveCategory()
    {
        return $this->belongsTo(LeaveCategory::class);
    }
}
