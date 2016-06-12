<?php


namespace App\repo\Event;


use App\Events\ApprovalNotificationEvent;
use Activity;
use App\Models\Info;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;

class StatusUpdateEvent implements EventInterface
{
    protected $qdn;

    public function fire($qdn)
    {
        $this->qdn = $qdn;
        
        $this->arrayToObject()->shoot();
    }

    private function arrayToObject()
    {
        $this->qdn = toObject($this->qdn);
        
        return $this;
    }
    
    public function shoot()
    {
        Activity::log("Approved {$this->qdn->info->control_id} : {$this->qdn->info->discrepancy_category} and commented - {$this->qdn->request->ApproverMessage}");
        Event::fire(new ApprovalNotificationEvent($this->qdn->info, $this->qdn->request->ApproverMessage)); //flash success alert message

        $closure = Info::withClosure($this->qdn->slug)->closure;


        $msg = $closure->other_department && $closure->production && $closure->quality_assurance && $closure->process_engineering
            ? 'Successfully updated! Issued QDN is now subject for QA Verification!'
            : 'Successfully updated! Issued QDN still waiting for other approvers!';

        Flash::success($msg);
    }
}