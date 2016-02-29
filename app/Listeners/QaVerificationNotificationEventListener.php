<?php

namespace App\Listeners;

use App\Events\QaVerificationNotificationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QaVerificationNotificationEventListener
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
     * @param  QaVerificationNotificationEvent  $event
     * @return void
     */
    public function handle(QaVerificationNotificationEvent $event)
    {
        //
    }
}
