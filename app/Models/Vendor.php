<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Vendor extends Authenticatable
{
    use Notifiable;  // Notifiable trait is used to send notifications

    protected $table = 'vendors';  // You already have this, no need to change

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'image',
        'city',
        'address',
    ];

    // Make sure to hash passwords before saving
    public static function boot()
    {
        parent::boot();

        static::creating(function ($vendor) {
            if ($vendor->password) {
                $vendor->password = Hash::make($vendor->password);
            }
        });

        static::updating(function ($vendor) {
            if ($vendor->password) {
                $vendor->password = Hash::make($vendor->password);
            }
        });
    }

    public function category()
{
    return $this->belongsTo(Category::class, 'category_id', 'id');
}


public function subcategories()
{
    return $this->belongsToMany(SubCategory::class, 'vendor_subcategory', 'vendor_id', 'subcategory_id');

}

public function walletRecharges()
{
    return $this->hasMany(WalletRecharge::class, 'vendor_id');
}

public function availability()
{
    return $this->hasOne(Avalibality::class, 'vendor_id');
}
}
