<?php namespace App\repo\Event;


use App\Events\EventLogs;
use Illuminate\Support\Facades\Event;

class PeVerificationDraftEvent implements EventInterface {

    /**
     * @param $qdn
     */
    public function fire($qdn)
    {
        Event::fire(new EventLogs(user(), 'P.E. save as draft and not yet validate' . $qdn->control_id));
    }
}