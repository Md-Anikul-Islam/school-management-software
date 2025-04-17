<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'name',
        'organization_name',
        'email',
        'phone',
        'address',
        'country',
        'photo',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }
}
