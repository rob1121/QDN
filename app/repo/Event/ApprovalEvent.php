<?php namespace App\repo\Event;

use App\Events\ApprovalNotificationEvent;
use App\Events\EventLogs;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;

class ApprovalEvent implements EventInterface {
    /**
     * @param $qdn
     */
    public function fire($qdn)
    {
        Event::fire(new EventLogs(user(), 'Incomplete: save and proceed' . $qdn->control_id));
        Event::fire(new ApprovalNotificationEvent($qdn, 'Answered by' . user()->employee->name));
        Flash::success('Successfully save! Issued QDN is now subject for Approval!');
    }
}