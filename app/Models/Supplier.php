<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'supplier_name',
        'email',
        'phone',
        'address',
        'school_id',
        'created_by',
        'updated_by',
    ];
}
