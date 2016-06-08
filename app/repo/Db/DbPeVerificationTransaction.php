<?php namespace App\repo\Db;

use App\Employee;
use App\Models\InvolvePerson;
use App\repo\Event\ClosureStatusEvent;
use App\repo\Event\EventInterface;
use App\repo\Event\PeVerificationDraftEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DbPeVerificationTransaction {

    public $qdn;
    public $request;
    protected $involvePerson = '';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function setQdn($slug)
    {
        $this->qdn = $slug;
        
        return $this;
    }
    
    public function save()
    {
        $this->update()
            ->syncRelationship()
            ->removeCacheUser();
        
        return $this;
    }

    protected function update()
    {
        $this->qdn->update($this->request->all());

        return $this;
    }

    public function syncRelationship()
    {
        $this->syncInvolvePerson()
            ->syncClosure();

        return $this;
    }

    private function removeCacheUser()
    {
        Cache::forget($this->qdn->slug);

        return $this;
    }

    public function PeVerificationEvent()
    {
        $this->listen(new ClosureStatusEvent, ['info' => $this->qdn, 'request' => $this->request]);

        return $this;
    }

    public function PeVerificationDraftEvent()
    {
        $this->listen(new PeVerificationDraftEvent, $this->qdn);

        return $this;
    }

    protected function getInvolvePerson()
    {
        return collect(array_unique($this->request->receiver_name))
            ->map(function($name) {
                return $this->setInvolvePerson($name);
            });
    }

    protected function setInvolvePerson($name)
    {
        $emp = Employee::whereName($name)->first();

        return new InvolvePerson([
            'station' => $emp->station,
            'originator_id' => $this->involvePerson->originator_id,
            'originator_name' => $this->involvePerson->originator_name,
            'receiver_id' => $emp->user_id,
            'receiver_name' => $name]);
    }

    public function getInvolvePersonStation()
    {
        return collect(array_unique($this->request->receiver_name))->map(function($name){
            return Employee::whereName($name)->first()->station;
        });
    }

    public function collection()
    {
        return array_add($this->request->all(),
            'department',
            ['emp_dept' => $this->getInvolvePersonStation(), 'slug' => $this->qdn]
        );
    }

    private function listen(EventInterface $event, $variables)
    {
        $event->fire($variables);
    }

    protected function syncInvolvePerson()
    {
        $this->involvePerson = $this->qdn->involvePerson()->first();

        $this->qdn->involvePerson()->delete();
        $this->qdn->involvePerson()->saveMany($this->getInvolvePerson());
        
        return $this;
    }

    protected function syncClosure()
    {
        $this->qdn->closure()->update([
            'status' => $this->request->status,
            'pe_verified_by' => user()->employee->name
        ]);
    }
}