<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Books extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'author',
        'subject_code',
        'price',
        'quantity',
        'rack_no',
        'status',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function issue()
    {
        return $this->hasMany(Issue::class, 'book_id');
    }
}
