<?php namespace App\repo\Event;

use Activity;

class PeVerificationDraftEvent implements EventInterface {
    public function fire($qdn)
    {
        Activity::log("P.E. Save as draft and not yet validate {$qdn->control_id} : {$qdn->discrepancy_category}");
    }
}