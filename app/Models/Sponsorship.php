<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsorship extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'sponsor_id',
        'start_date',
        'end_date',
        'amount',
        'payment_date',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}
