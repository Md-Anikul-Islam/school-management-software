<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'asset_id',
        'vendor_id',
        'purchase_by',
        'quantity',
        'unit',
        'purchase_price',
        'purchase_date',
        'service_date',
        'expire_date',
        'is_approved',
        'school_id',
        'created_by',
        'updated_by',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function purchaseBy()
    {
        return $this->belongsTo(User::class, 'purchase_by');
    }
}
