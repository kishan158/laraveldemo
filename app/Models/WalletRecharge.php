<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletRecharge extends Model
{
    protected $table ="wallet_recharges";
    protected $fillable =[
        'vendor_id',
        'amount',
        'status',
        'transaction_id',
        'recharged_at',
        
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id'); // Assuming 'vendor_id' is the foreign key
    }
}
