<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    protected $fillable = ['service_id', 'subservice', 'image'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
   
}
