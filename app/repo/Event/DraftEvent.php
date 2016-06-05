<?php namespace App\repo\Event;

use App\Events\EventLogs;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;

class DraftEvent implements EventInterface {
    /**
     * @param $qdn
     */
    public function fire($qdn)
    {
        Event::fire(new EventLogs(user(), 'Incomplete: save as draft' . $qdn->control_id));
        Flash::success('Successfully save! Issued QDN are save as draft and still subject for completion!');
    }
}