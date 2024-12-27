<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferEarn extends Model
{
    protected $table = "refer_earns";
    protected $fillable = [
        'user_id',
        'referrer_id',
        'credit',
        'debit',
        

    ];
}



