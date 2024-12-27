<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Customer extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'phone', 'address', 'city', 'pin_code'];

    // Optionally, you can specify the table if it's different from the default
    protected $table = 'customers';
    public function orders()
{
    return $this->hasMany(Order::class, 'customer_id'); // 'customer_id' is the foreign key in the 'orders' table
}
}
