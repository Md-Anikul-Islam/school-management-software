<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'path',
        'type',
        'parent_id',
    ];

    public function children()
    {
        return $this->hasMany(Media::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Media::class, 'parent_id');
    }
}
