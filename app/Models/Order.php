<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table="orders";
    protected $fillable = [
        'order_id',
        'customer_id',
        'total_price',
        'cart',
        'date',
        'time',
        'address',
        'notify_status',
    ];

    protected $casts = [
        'cart' => 'array', // Automatically cast JSON to an array
    ];

    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class);
    // }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
 
}
