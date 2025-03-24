<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivitiesCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'font_awesome_icon',
        'school_id',
        'created_by',
        'updated_by',
    ];
}
