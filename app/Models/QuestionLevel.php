<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionLevel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function questionBanks()
    {
        return $this->hasMany(QuestionBank::class);
    }
}
