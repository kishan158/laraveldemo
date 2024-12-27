<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table="services";
    protected $fillable =[
        'service',
    ];

//     public function packages()
// {
//     return $this->hasMany(Package::class, 'service_id');
// }
public function packages()
{
    return $this->hasMany(Package::class);
}
public function subservices()
    {
        return $this->hasMany(Subservice::class);  // A service can have multiple subservices
    }
}
