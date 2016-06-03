<?php namespace App\repo\Event;


use App\Events\EventLogs;
use Illuminate\Support\Facades\Event;

class DownloadEvent implements EventInterface {
    public function fire($qdn)
    {
        Event::fire(new EventLogs(user(), 'download' . $qdn->control_id));
    }
}