<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeCustomize extends Model
{
    protected $table ="home_customizes";
    protected $fillable =[
        'title',
        'banner1',
        'banner2',
        'banner3',
        'mobile_view',
        'banner4',
    ];
}
