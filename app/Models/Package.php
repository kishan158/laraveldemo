<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = "packages";
    protected $fillable =[
        'service_id',
        'package',
        'price',
        'previous_price',
        'time_duration',
        'warranty',
        'discount',
        'city',
        'pincode',
        'description',
        'status',
        'image',
     
    ];
    public function service()
{
    return $this->belongsTo(Service::class);  
}

public function subservice()
{
    return $this->belongsTo(SubService::class);  
}
public function servicetitle()
{
    return $this->belongsTo(ServiceTitle::class, 'service_title_id', 'id');
}
}
