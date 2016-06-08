<?php namespace App\repo\Event;



use Activity;

class DownloadEvent implements EventInterface {
    public function fire($qdn)
    {
        Activity::log("Download QDN {$qdn->control_id } : {$qdn->discrepancy_category}");
    }
}