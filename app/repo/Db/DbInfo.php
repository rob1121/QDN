<?php namespace App\repo\Db;

use App\Employee;
use App\Models\CauseOfDefect;
use App\Models\Closure;
use App\Models\ContainmentAction;
use App\Models\CorrectiveAction;
use App\Models\Info;
use App\Models\InvolvePerson;
use App\Models\PreventiveAction;
use App\Models\QdnCycle;
use App\repo\Event\EventInterface;
use App\repo\Event\StoreEvent;
use App\repo\Traits\DateTime;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class DbInfo implements DbInterface {
    use ValidatesRequests;
    use DateTime;

    protected $request;
    protected $qdn;
    protected $hasDuplicate;

    protected static $rules = [
        'package_type' => 'required',
        'device_name' => 'required',
        'lot_id_number' => 'required',
        'lot_quantity' => 'required | numeric',
        'job_order_number' => 'required',
        'machine' => 'required',
        'station' => 'required',
        'receiver_name' => 'required',
        'major' => 'required',
        'failure_mode' => 'required',
        'discrepancy_category' => 'required',
        'problem_description' => 'required',
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function store()
    {
            $this->validateRequest()
                ->saveToDatabase()
                ->syncRelationship()
                ->event();
    }

    protected function validateRequest()
    {
        $this->validate($this->request, self::$rules);

        $this->hasDuplicate = Info::isExist($this->request)->count() > 0;

        return $this;
    }

    protected function saveToDatabase()
    {
        if( ! $this->hasDuplicate)
        {
            $lastIn     = Info::last();
            $lastInYear = substr($lastIn->control_id, 0, 2);
            $lastInId   = substr($lastIn->control_id, 3);
            $control_id = $this->yearNow() == $lastInYear ? $lastInId + 1 : 1;
            $customer   = "not yet specified" == $this->request->customer ? $this->request->customerField : $this->request->customer;

            $this->qdn  = Info::create($this->request->all());
            $this->qdn->update([
                'disposition' => 'use as is',
                'control_id'  => $control_id,
                'customer'    => $customer,
            ]);
        }

        return $this;
    }
    
    protected function syncRelationship()
    {
        if( ! $this->hasDuplicate)
        {
            $this->syncInvolvePerson()
                ->syncActions();
        }

        return $this;
    }
    
    protected function event()
    {
        $this->hasDuplicate
            ? Flash::warning('Oh Snap!! This QDN is already registered. In doubt? ask QA to assist you!')
            : $this->fire(new StoreEvent);
    }

    protected function syncInvolvePerson()
    {
        collect($this->request->receiver_name)->map(function($name) {
            $person = Employee::byName($name);

            InvolvePerson::create([
                'info_id' => $this->qdn->id,
                'station' => $person->station,
                'originator_id' => user()->employee_id,
                'originator_name' => user()->employee->name,
                'receiver_id' => $person->user_id,
                'receiver_name' => $person->name,
            ]);
        });
        
        return $this;
    }

    protected function syncActions()
    {
        collect([new CauseOfDefect, new CorrectiveAction, new ContainmentAction, new PreventiveAction, new QdnCycle, new Closure])
            ->map(function($model) { $model->create(['info_id' => $this->qdn->id]); });

        Closure::whereInfoId($this->qdn->id)->update(['status' => 'p.e. verification']);

        return $this;
    }

    protected function fire(EventInterface $event)
    {
        $event->fire($this->qdn);
    }
}