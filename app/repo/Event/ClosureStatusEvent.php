<?php


namespace App\repo\Event;

use App\Events\PeVerificationNotificationEvent;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;
use Activity;

class ClosureStatusEvent implements EventInterface
{
    public function fire($qdn)
    {
        Activity::log(sprintf("P.E. validate {$qdn['info']->control_id} {$qdn['request']->status} : {$qdn['request']->ValidationMessage}"));
        Event::fire(new PeVerificationNotificationEvent($qdn['info'], $qdn['request']->ValidationMessage));
        Flash::success('Successfully Verified !! QDN are now ready for completion!');
    }
}