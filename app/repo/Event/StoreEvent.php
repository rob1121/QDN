<?php namespace App\repo\Event;

use App\Events\EmailQdnNotificationEvent;
use Activity;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;

class StoreEvent implements EventInterface {
    public function fire($qdn)
    {
        Activity::log('Issue QDN {$qdn->control_id} : {$qdn->discrepancy_category}');
        Event::fire(new EmailQdnNotificationEvent($qdn));
        Flash::success('Success! Team responsible will be notified regarding the issue via email!');
    }
}