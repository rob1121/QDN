<?php


namespace App\repo\Event;

use App\Events\QdnClosedNotificationEvent;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;
use Activity;

class QdnClosureEvent implements EventInterface
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
        Activity:log("Verify {$this->qdn->info->control_id} {$this->qdn->request->ValidationResult}: {$this->qdn->request->ApproverMessage} and mark as closed");
        Event::fire(new QdnClosedNotificationEvent($this->qdn->info)); // send email notification
        Flash::success('Successfully updated! Issued QDN are now closed!'); // add flash alert notification
    }
}