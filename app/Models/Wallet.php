<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table="wallets";
    protected $fillable=[
        'vendor_id',
        'order_id',
        'credit',
        'debit',
    ];

    public function vendor()
{
    return $this->belongsTo(Vendor::class, 'vendor_id');
}
}
