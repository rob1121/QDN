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
    protected $isExist;
    protected $control_id;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    public function store()
    {
            $this->validateRequest()
                ->controlId()
                ->save()
                ->syncRelationship()
                ->event();
    }

    protected function validateRequest()
    {
        $this->validate($this->request, Info::rules);

        if (Info::isExist($this->request))
            return Response::json(['0' => 'QDN already exist!!'], 442);

        return $this;
    }

    protected function save()
    {
        if( ! $this->isExist)
        {
            $this->qdn  = Info::create($this->request->all());
            $this->qdn->disposition = 'use as is';
            $this->qdn->control_id = $this->control_id;
            $this->qdn->customer = $this->getCustomer();

            $this->qdn->save();
        }

        return $this;
    }

    protected function syncRelationship()
    {
        if( ! $this->isExist)
        {
            $this->syncInvolvePerson()
                ->syncActions();
        }

        return $this;
    }

    protected function event()
    {
//        $this->isExist
//            ? Flash::warning('Oh Snap!! This QDN is already registered. In doubt? ask QA to assist you!')
//            : $this->fire(new StoreEvent);

        return $this->isExist
            ? "Oh Snap!! This QDN is already registered. In doubt? ask QA to assist you!"
            : $this->fire(new StoreEvent);
    }

    protected function syncInvolvePerson()
    {
        collect($this->request->receiver_name)->map(function($name) {
            InvolvePerson::store($this->qdn->id, Employee::byName($name));
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

    public function controlId()
    {
        $lastIn = Info::last();
        $lastInYear = substr($lastIn->control_id, 0, 2);
        $lastInId = substr($lastIn->control_id, 3);
        $control_id = $this->yearNow() == $lastInYear ? $lastInId + 1 : 1;
        $this->control_id = $this->date()->format('y') . "-" . sprintf("%'.04d", $control_id);
        return $this;
    }

    protected function getCustomer()
    {
        $customer = "not yet specified" == $this->request->customer
            ? $this->request->customerField
            : $this->request->customer;
        return $customer;
    }
}