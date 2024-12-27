<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderOpt extends Model
{
    protected $table= "order_opts";
    protected $fillable = [
        'user_id',
        'order_id',
        'otp',
        'status',

    ];
}
