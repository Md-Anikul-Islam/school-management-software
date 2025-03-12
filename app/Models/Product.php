<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'category_id',
        'buying_price',
        'selling_price',
        'description',
        'school_id',
        'created_by',
        'updated_by'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
