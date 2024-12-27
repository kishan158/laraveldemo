<?php

namespace App\Listeners;

use App\Events\NewOrderCreated;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderNotification;

class SendOrderNotification
{
    public function handle(NewOrderCreated $event)
    {
        $vendors = User::all(); 
        Notification::send($vendors, new OrderNotification($event->order));
    }
}
