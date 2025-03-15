<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionBank extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'question_group_id',
        'question_level_id',
        'question',
        'explanation',
        'upload',
        'hints',
        'mark',
        'question_type',
        'options',
        'correct_answers',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class);
    }

    public function questionLevel()
    {
        return $this->belongsTo(QuestionLevel::class);
    }
}
