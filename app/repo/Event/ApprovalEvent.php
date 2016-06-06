<?php namespace App\repo\Event;

use App\Events\ApprovalNotificationEvent;
use Activity;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;

class ApprovalEvent implements EventInterface {
    public function fire($qdn)
    {
        Activity::log('Incomplete: save and proceed {$qdn->control_id} : {$qdn->discrepancy_category}');
        Event::fire(new ApprovalNotificationEvent($qdn, 'Answered by' . user()->employee->name));
        Flash::success('Successfully save! Issued QDN is now subject for Approval!');
    }
}