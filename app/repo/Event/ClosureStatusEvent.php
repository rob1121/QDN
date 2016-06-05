<?php


namespace App\repo\Event;


use App\Events\EventLogs;
use App\Events\PeVerificationNotificationEvent;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;

class ClosureStatusEvent implements EventInterface
{
    public function fire($qdn)
    {
        Event::fire(new EventLogs("P.E. validate {$qdn['info']->control_id} {$qdn['request']->status} : {$qdn['request']->ValidationMessage}"));
        Event::fire(new PeVerificationNotificationEvent($qdn['info'], $qdn['request']->ValidationMessage));
        Flash::success('Successfully Verified !! QDN are now ready for completion!');
    }
}