<?php namespace App\repo\Event;

use Laracasts\Flash\Flash;
use Activity;

class DraftEvent implements EventInterface {
    public function fire($qdn)
    {
        Activity::log("Incomplete: save as draft {$qdn->control_id } : {$qdn->discrepancy_category}");
        Flash::success('Successfully save! Issued QDN are save as draft and still subject for completion!');
    }
}