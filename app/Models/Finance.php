<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $table="finances";
    protected $fillable=[
        'vendor_id',
        'gst_details',
        'pan_card_details',
        'bank_details',
        'personal_details',
        
    ];
}
