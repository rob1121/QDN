<?php namespace App\repo\Db;

use App\Models\Closure;
use App\repo\Event\EventInterface;
use App\repo\Event\QdnClosureEvent;
use App\repo\Traits\DateTime;
use Illuminate\Http\Request;

class DbQaVerificationTransaction {

    use DateTime;

    protected $qdn;
    private $request;

    public function __construct(Request $request)
    {

        $this->request = $request;
    }
    public function update($qdn)
    {
        $this->qdn = $qdn;

        $this->save()
            ->event(new QdnClosureEvent);
    }

    protected function save()
    {
        Closure::where('info_id', $this->qdn->id)
            ->update([
                'containment_action_taken' => $this->request->containment_action_taken,
                'corrective_action_taken' => $this->request->corrective_action_taken,
                'close_by' => user()->employee->name,
                'date_sign' => $this->date(),
                'status' => 'closed',
            ]);

        return $this;
    }

    private function event(EventInterface $event)
    {
        $event->fire(['info' => $this->qdn, 'request' => $this->request]);
    }
}