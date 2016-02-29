<?php

namespace App\Listeners;

use App\Events\PeVerificationNotificationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PeVerificationNotificationEventListener
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
     * @param  PeVerificationNotificationEvent  $event
     * @return void
     */
    public function handle(PeVerificationNotificationEvent $event)
    {
        //
    }
}
