<?php

namespace App\Listeners;

use App\Models\Admin;
use App\Events\OrderBatal;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\DatabaseNotification;

class DeleteNotification
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
     * @param  \App\Providers\OrderBatal  $event
     * @return void
     */
    public function handle(OrderBatal $event)
    {
        $admins = Admin::all();

        foreach ($admins as $admin) {
            foreach ($admin->unreadNotifications as $notification){
                if($notification->data['order_id'] == $event->order->id){
                    DB::delete('delete from notifications where id ="'.$notification->id.'"');
                }
            }
        }

    }
}
