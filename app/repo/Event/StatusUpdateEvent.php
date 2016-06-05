<?php


namespace App\repo\Event;


use App\Events\ApprovalNotificationEvent;
use App\Events\EventLogs;
use App\Models\Info;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;

class StatusUpdateEvent implements EventInterface
{
    public function fire($qdn)
    {
        Event::fire(new EventLogs("{$qdn['info']->control_id} - {$qdn['request']->approver_radio} : {$qdn['request']->ApproverMessage}"));
        Event::fire(new ApprovalNotificationEvent($qdn['info'], $qdn['request']->ApproverMessage)); //flash success alert message

        $closure     = Info::whereSlug($qdn->slug)->with('closure')->first();
        $closure = $closure->closure;

        $msg = $closure->other_department && $closure->production && $closure->quality_assurance && $closure->process_engineering
            ? 'Successfully updated! Issued QDN still waiting for other approvers!'
            : 'Successfully updated! Issued QDN is now subject for QA Verification!';

            Flash::success($msg);
    }
}