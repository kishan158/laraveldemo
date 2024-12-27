<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QR extends Model
{
    protected $table = "q_r_s";
    protected $fillable =[
        'image',
        'upi_id',
    ];
}
