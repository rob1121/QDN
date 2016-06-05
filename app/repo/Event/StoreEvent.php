<?php namespace App\repo\Event;

use App\Events\EmailQdnNotificationEvent;
use App\Events\EventLogs;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;

class StoreEvent implements EventInterface {
    /**
     * @param $qdn
     */
    public function fire($qdn)
    {
        Event::fire(new EventLogs(user(), 'issue QDN: ' . $qdn->control_id));
        Event::fire(new EmailQdnNotificationEvent($qdn));
        Flash::success('Success! Team responsible will be notified regarding the issue via email!');
    }
}