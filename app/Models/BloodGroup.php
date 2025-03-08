<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
