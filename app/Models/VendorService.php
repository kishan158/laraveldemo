<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorService extends Model
{
    protected $table= "vendor_services";
    protected $fillable =[
        'service_id',
        'package_id',
        'price',
        'city',
        'pincode',
        'description',
       
    ];

    public function service()
{
    return $this->belongsTo(Service::class);
}

public function package()
{
    return $this->belongsTo(Package::class);
}
}
