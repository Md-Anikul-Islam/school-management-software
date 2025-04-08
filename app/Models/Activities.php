<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activities extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'activity_category_id',
        'description',
        'time_frame_start',
        'time_frame_end',
        'time_at',
        'attachment',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function activityCategory()
    {
        return $this->belongsTo(ActivitiesCategory::class, 'activity_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
