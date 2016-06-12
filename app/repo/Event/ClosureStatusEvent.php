<?php


namespace App\repo\Event;

use App\Events\PeVerificationNotificationEvent;
use Illuminate\Support\Facades\Event;
use Laracasts\Flash\Flash;
use Activity;

class ClosureStatusEvent implements EventInterface
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
    
    private function shoot()
    {
        Activity::log(sprintf("P.E. validate {$this->qdn->info->control_id} {$this->qdn->request->status} : {$this->qdn->request->ValidationMessage}"));
        Event::fire(new PeVerificationNotificationEvent($this->qdn->info, $this->qdn->request->ValidationMessage));
        Flash::success('Successfully Verified !! QDN are now ready for completion!');
    }
    
}