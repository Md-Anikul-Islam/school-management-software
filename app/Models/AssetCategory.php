<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'asset_category_id');
    }
}
