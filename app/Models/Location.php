<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'location',
        'description',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'location_id');
    }

    public function assetAssignments()
    {
        return $this->hasMany(AssetAssignment::class, 'location_id');
    }
}
