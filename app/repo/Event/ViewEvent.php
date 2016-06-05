<?php


namespace App\repo\Event;


use App\Events\EventLogs;
use Illuminate\Support\Facades\Event;

class ViewEvent implements EventInterface
{
    public function fire($qdn)
    {
        Event::fire(new EventLogs('view' . $qdn->control_id));
    }
}