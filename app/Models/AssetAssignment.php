<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetAssignment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'asset_id',
        'assign_quantity',
        'role_id',
        'check_out_to',
        'due_date',
        'check_out_date',
        'check_in_date',
        'location_id',
        'status',
        'note',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

//    public function role()
//    {
//        return $this->belongsTo(Role::class);
//    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function checkOutTo()
    {
        return $this->belongsTo(User::class, 'check_out_to');
    }
}
