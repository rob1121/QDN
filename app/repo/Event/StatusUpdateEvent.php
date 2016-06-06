<?php


namespace App\repo\Event;


use App\Events\ApprovalNotificationEvent;
use Activity;
use App\Models\Info;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;

class StatusUpdateEvent implements EventInterface
{
    public function fire($qdn)
    {
        Activity::log("Approved {$qdn['info']->control_id} : {$qdn['info']->discrepancy_category} and commented - {$qdn['request']->ApproverMessage}");
        Event::fire(new ApprovalNotificationEvent($qdn['info'], $qdn['request']->ApproverMessage)); //flash success alert message

        $info     = Info::whereSlug($qdn['info']->slug)->with('closure')->first();
        $closure = $info->closure;

        $msg = $closure->other_department && $closure->production && $closure->quality_assurance && $closure->process_engineering
            ? 'Successfully updated! Issued QDN is now subject for QA Verification!'
            : 'Successfully updated! Issued QDN still waiting for other approvers!';
        
        Flash::success($msg);
    }
}