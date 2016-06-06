<?php namespace App\repo\Event;



use Activity;

class DownloadEvent implements EventInterface {
    public function fire($qdn)
    {
        Activity::log('Download QDN {$slug->control_id} : {$slug->discrepancy_category}');
    }
}