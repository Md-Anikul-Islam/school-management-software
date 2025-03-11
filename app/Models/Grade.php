<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'grade_name',
        'grade_point',
        'mark_from',
        'mark_upto',
        'note',
        'school_id',
        'created_by',
        'updated_by',
    ];
}
