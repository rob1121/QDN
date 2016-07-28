<?php namespace App\repo\Db;

use App\Employee;
use App\Models\Info;
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

    public function save(Info $qdn)
    {
        $this->qdn = $qdn;

        $this->update()
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
        $this->syncInvolvePerson();

        return $this;
    }

    private function removeCacheUser()
    {
        Cache::forget($this->qdn->slug);

        return $this;
    }

    public function PeVerificationEvent()
    {
        $this->syncClosure()
            ->listen(new ClosureStatusEvent, [
                'info' => $this->qdn,
                'request' => $this->request
            ]);
    }

    public function PeVerificationDraftEvent()
    {
        $this->listen(new PeVerificationDraftEvent, $this->qdn);

        return $this;
    }

    protected function getInvolvePerson()
    {
        return collect($this->request->receiver_name)
            ->unique()
            ->map(function($name) {
                return $this->setInvolvePerson($name);
            });
    }

    protected function setInvolvePerson($name)
    {
        $emp = Employee::whereName($name)->first();

        return new InvolvePerson($this->InvolvePersonCollection($name, $emp));
    }
    
    protected function InvolvePersonCollection($name, $emp)
    {
        return [
            'station' => $emp->station,
            'originator_id' => $this->involvePerson->originator_id,
            'originator_name' => $this->involvePerson->originator_name,
            'receiver_id' => $emp->user_id,
            'receiver_name' => $name];
    }

    public function collection()
    {
        $array = collect($this->request->all())->put('department',$this->getInvolvePersonStation());
        return $array->put('slug', $this->qdn);
    }

    public function getInvolvePersonStation()
    {
        return collect($this->request->receiver_name)->unique()->map(function($name){
            return Employee::whereName($name)->first()->station;
        });
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
        
        return $this;
    }
}