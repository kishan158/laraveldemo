<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WidthrawRequest extends Model
{
    protected $table = "widthraw_requests";
    protected $fillable = [
        'user_id',
        'account_no',
        'amount',
        'status',
        

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kyc()
    {
        return $this->hasOne(KYC::class, 'user_id', 'user_id');  // Assuming 'user_id' is the linking field
    }
}
