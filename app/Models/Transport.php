<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transport extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'route_name',
        'vehicle_no',
        'route_fare',
        'note',
        'school_id',
        'created_by',
        'updated_by',
    ];
}
