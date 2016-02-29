<?php

namespace App\Listeners;

use App\Events\ApprovalNotificationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovalNotificationEventListener
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
     * @param  ApprovalNotificationEvent  $event
     * @return void
     */
    public function handle(ApprovalNotificationEvent $event)
    {
        //
    }
}
