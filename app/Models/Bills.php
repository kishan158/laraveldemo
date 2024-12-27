<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    protected $table= "bills";
    protected $fillable=[
        'user_id',
        'order_id',
        'vendor_id',
        'bill',
        'revisite',
        'revisite_sent_status',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
