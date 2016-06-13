<?php


namespace App\repo\Event;

use App\Events\QdnClosedNotificationEvent;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;
use Activity;

class QdnClosureEvent implements EventInterface
{
    public function fire($qdn)
    {

        Activity:log("Verify {$qdn['info']->control_id} {$qdn['request']->ValidationResult}: {$qdn['request']->ApproverMessage} and mark as closed");
        Event::fire(new QdnClosedNotificationEvent($qdn['info'])); // send email notification
        Flash::success('Successfully updated! Issued QDN are now closed!'); // add flash alert notification
    }
}