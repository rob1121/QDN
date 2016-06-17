<?php namespace App\repo\Db;

use App\Models\Info;
use App\repo\Event\EventInterface;
use App\repo\Event\StatusUpdateEvent;
use Exception;
use Illuminate\Http\Request;
use Activity;

class DbApproverTransaction {
    
    protected $user;
    protected $request;
    protected $qdn;

    public function __construct(Request $request)
    {

        $this->request = $request;
    }
    
    public function update(Info $qdn)
    {
        $this->qdn = $qdn;
        $this->user = user()->employee;
        
        return $this->save();
    }

    protected function save()
    {

        if ('reject' == $this->request->approver_radio) 
        {
            $this->qdn->closure()
                ->update(['status' => 'Incomplete Fill-Up', $this->user->department => '']);
            
            return false;
        }
        
        return $this->syncClosure()
            ->updateApproveStatus()
            ->event(new StatusUpdateEvent);
    }

    protected function syncClosure()
    {
        $closure = [$this->user->department => $this->user->name];

        if (hasNoOtherDepartmentInvolve($this->user, $this->qdn))
            $closure['other_Department'] = $this->user->name;

        $this->qdn->closure()->update($closure);
        
        return $this;
    }

    protected function updateApproveStatus()
    {
        Cache::forget($this->qdn->slug);

        $status['status'] = $this->status()
            ? 'Q.a. Verification'
            : 'Incomplete Approval';

        $this->qdn->closure()->update($status);
        
        return $this;
    }

    protected function event(EventInterface $event)
    {
        return $event->fire(['info' => $this->qdn, 'request' => $this->request]);
    }

    private function status()
    {
        $closure = Info::withClosure($this->qdn->slug)->closure;
        $booleanClosure = $closure->other_department && $closure->production && $closure->quality_assurance && $closure->process_engineering;

        if ($booleanClosure && $this->qdn->status == 'Q.a. Verification') 
        {
            throw new Exception("QDN signatories is not yet complete and the status is already Q.a. Verification" . __LINE__ . " of " . __FILE__);
        }

        return $booleanClosure;
    }
}