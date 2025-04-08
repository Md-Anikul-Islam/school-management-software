<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ebooks extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'author',
        'class_id',
        'cover_photo',
        'file',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function class()
    {
        return $this->belongsTo(ClassName::class, 'class_id');
    }
}
