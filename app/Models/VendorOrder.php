<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorOrder extends Model
{
    protected $table= "vendor_orders";
    protected $fillable=[
        'order_id',
        'customer_id',
        'vendor_id',
        'revisite_status',
        'notify_status',
    ];

    public function order()
{
    return $this->belongsTo(Order::class, 'order_id', 'order_id'); // 'order_id' is the foreign key in the 'vendor_orders' table, and 'order_id' is the primary key in the 'orders' table
}

public function vendor()
{
    return $this->belongsTo(Vendor::class, 'vendor_id');
}
public function customer()
{
    return $this->belongsTo(User::class, 'customer_id');
}

}
