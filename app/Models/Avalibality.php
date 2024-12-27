<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avalibality extends Model
{
    protected $table = "avalibalities";
    protected $fillable = [
        'date',
        'vendor_id',
    ];
}
