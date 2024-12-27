<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $table= "registers";
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'company_name',
        'gstin',
        'address',
        'status',
        'notify_status',
    ];
}
