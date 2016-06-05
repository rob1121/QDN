<?php


namespace App\repo\Event;


use App\Events\EventLogs;
use App\Events\QdnClosedNotificationEvent;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;

class QdnClosureEvent implements EventInterface
{
    public function fire($qdn)
    {
        Event::fire(new EventLogs("Verify {$qdn['info']->control_id} {$qdn['request']->ValidationResult}: {$qdn['request']->ApproverMessage}"));
        Event::fire(new QdnClosedNotificationEvent($qdn['info'])); // send email notification
        Flash::success('Successfully updated! Issued QDN are now closed!'); // add flash alert notification
    }
}