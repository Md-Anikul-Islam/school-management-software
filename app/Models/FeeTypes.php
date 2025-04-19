<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeTypes extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'fee_type',
        'note',
        'is_monthly',
        'school_id',
        'created_by',
        'updated_by',
    ];
}
