<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $table = "invites";
    protected $fillable =[
        'referrer_id',
        'user_id',
        'invite_code',
    ];
}
