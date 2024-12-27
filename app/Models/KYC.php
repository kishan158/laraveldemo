<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KYC extends Model
{
    protected $table = "k_y_c_s";
    protected $fillable =[
        'user_id',
        'name',
        'pan_no',
        'adhar_no',
        'bank_name',
        'account_no',
        'bank_branch',
        'bank_ifsc',
       


    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
