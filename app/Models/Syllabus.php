<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Syllabus extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'class_id',
        'date',
        'uploaded_by',
        'file',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function className()
    {
        return $this->belongsTo(ClassName::class, 'class_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
}
