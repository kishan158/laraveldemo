<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'company_name',
        'gstin',
        'address',
        'status',
        'phone',
        'city',
        'pin_code',
        'role',
        'otp',
         'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function invite()
{
    return $this->hasOne(Invite::class, 'user_id');
}


public function widthrawRequests()
{
    return $this->hasMany(WidthrawRequest::class);
}

public function kyc()
{
    return $this->hasOne(KYC::class, 'user_id');
}
}
