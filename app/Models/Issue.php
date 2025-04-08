<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'library_id',
        'book_id',
        'author',
        'subject_code',
        'serial_no',
        'due_date',
        'note',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function book()
    {
        return $this->belongsTo(Books::class, 'book_id');
    }
}
