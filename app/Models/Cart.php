<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = "carts";
    protected $fillable=[
        'service_id',
        'package_id',
        'price',
        'quantity',
       'total_amount',

    ];
}
