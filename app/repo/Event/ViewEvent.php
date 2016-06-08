<?php


namespace App\repo\Event;

use Activity;

class ViewEvent implements EventInterface
{
    public function fire($qdn)
    {
        Activity::log("View {$qdn->control_id}");
    }
}