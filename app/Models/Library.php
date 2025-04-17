<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Library extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'code',
        'fee',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function members()
    {
        return $this->hasMany(LibraryMember::class);
    }
}
