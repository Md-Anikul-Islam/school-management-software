<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'serial',
        'title',
        'status',
        'condition',
        'asset_category_id',
        'location_id',
        'attachment',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function assetCategory()
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function assetAssignments()
    {
        return $this->hasMany(AssetAssignment::class);
    }
}
