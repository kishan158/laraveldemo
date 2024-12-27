<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTitle extends Model
{
    protected $table = "service_titles";
    protected $fillable =[
        'service_id',
        'service_title',
        'image',
       
    ];

   
    public function service()
{
    return $this->belongsTo(Service::class);
}
}
