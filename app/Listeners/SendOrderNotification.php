<?php

namespace App\Listeners;

use App\Models\Admin;
use App\Events\Ordered;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Ordered  $event
     * @return void
     */
    public function handle(Ordered $event)
    {
        $admins = Admin::all();
        Notification::send($admins, new NewOrderNotification($event->order));
    }
}
