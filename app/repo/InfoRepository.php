<?php
namespace App\repo;
use App\Employee;
use App\Events\ApprovalNotificationEvent;
use App\Events\EventLogs;
use App\Events\PeVerificationNotificationEvent;
use App\Events\QdnClosedNotificationEvent;
use App\Models\CauseOfDefect;
use App\Models\Closure;
use App\Models\ContainmentAction;
use App\Models\CorrectiveAction;
use App\Models\Info;
use App\Models\InvolvePerson;
use App\Models\PreventiveAction;
use App\Models\QdnCycle;
use App\repo\File\cod;
use App\repo\File\cna;
use App\repo\File\ca;
use App\repo\File\pa;
use App\repo\File\ObjectiveEvidenceInterface;
use Auth;
use Cache;
use Carbon;
use DB;
use Event;
use Flash;
use Gate;
use JavaScript;
use Storage;
use Str;

class InfoRepository implements InfoRepositoryInterface {
	public $setMonth;
	public $setYear;

	/**
	 * @param $qdn
	 * @param $view
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function view($qdn, $view)
    {
		$this->logEvent('view' . $qdn->control_id);

		JavaScript::put([
			'link' => $this->links($qdn->slug),
			'qdn' => $qdn
		]);

		return view($view, compact('qdn'));
	}

    /**
     * @return mixed
     */
    public function user()
    {
		return Auth::user()->load('employee');
	}

    /**
     * @return mixed
     */
    public function date()
    {
		return Carbon::now('Asia/Manila');
	}

    /**
     * @return mixed
     */
    public function month()
    {
		return null == $this->setMonth ? $this->date()->format('m') : $this->setMonth;
	}

    /**
     * @return mixed
     */
    public function year()
    {
		return null == $this->setYear ? $this->date()->format('Y') : $this->setYear;
	}

    /**
     * @param $slug
     * @return array
     */
    public function links($slug)
    {
		return [
			'linkDraft'    => route('draft_link', ['slug' => $slug]),
			'linkApproval' => route('approval_link', ['slug' => $slug]),
		];
	}

    /**
     * @param $info
     * @param $request
     */
    public function save($info, $request)
    {
        $classes = [new cod, new cna, new ca, new pa];
        foreach($classes as $class)
            $this->update($class, $info, $request);
	}

    /**
     * @param $request
     * @return static
     */
    public function add($request)
    {
		$info = $this->AddInfo($request);
		$id = ['info_id' => $info->id];
		$this->AddInvolvePerson($request, $info->id);
		CauseOfDefect::create($id);
		CorrectiveAction::create($id);
		ContainmentAction::create($id);
		PreventiveAction::create($id);
		QdnCycle::create($id);
		Closure::create(['info_id' => $info->id, 'status' => 'p.e. verification']);
		
		return $info;
	}

    /**
     * @param $request
     * @return static
     */
    public function AddInfo($request)
    {
		$currentYear = Carbon::now('Asia/Manila')->format('y');

		$lastIn     = Info::orderBy('id', 'desc')->first();
		$lastInYear = substr($lastIn->control_id, 0, 2);
		$lastInId   = substr($lastIn->control_id, 3);
		$control_id = $currentYear == $lastInYear ? $lastInId + 1 : 1;
		$customer   = "not yet specified" == $request->customer ? $request->customerField : $request->customer;
		$info       = Info::create($request->all());
		$info->update([
			'disposition' => 'use as is',
			'control_id'  => $control_id,
			'customer'    => $customer,
		]);

		return $info;
	}

    /**
     * @param $request
     * @param $id
     */
    public function AddInvolvePerson($request, $id)
    {
		foreach ($request->receiver_name as $name)
        {
			$person = Employee::findBy('name', $name)->first();

			InvolvePerson::create([
				'info_id'         => $id,
				'station'      => $person->station,
				'originator_id'   => $this->user()->employee_id,
				'originator_name' => $this->user()->employee->name,
				'receiver_id'     => $person->user_id,
				'receiver_name'   => $person->name,
			]);
		}
	}

    /**
     * @param $request
     * @param $slug
     * @return array
     */
    public function SectionOneUpdate($request, $slug)
    {
		$slug->update($request->all());
		$arr_names     = [];
		$involvePerson = $slug->involvePerson()->first();
		$emp_dept      = [];
		foreach (array_unique($request->receiver_name) as $name)
        {
			$emp         = Employee::whereName($name)->first();
			$emp_dept[]  = $emp->station;
			$arr_names[] = new InvolvePerson([
				'station'      => $emp->station,
				'originator_id'   => $involvePerson->originator_id,
				'originator_name' => $involvePerson->originator_name,
				'receiver_id'     => $emp->user_id,
				'receiver_name'   => $name]);
		}

		$slug->involvePerson()->delete();
		$slug->involvePerson()->saveMany($arr_names);
		$collection = ['emp_dept' => $emp_dept, 'slug' => $slug];
		return $collection;
	}

    /**
     * @param $request
     * @param $qdn
     */
    public function UpdateClosureStatus($request, $qdn)
    {
		$qdn->closure()->update([
			'status'         => $request->status,
			'pe_verified_by' => $this->user()->employee->name,
		]);

        $this->logEvent('P.E. validate' . $qdn->control_id, $request->status . ": " . $request->ValidationMessage);
		Event::fire(new PeVerificationNotificationEvent($qdn, $request->ValidationMessage));
        $this->showMsg('Successfully Verified !! QDN are now ready for completion!');
    }

    /**
     * @param $request
     * @param $qdn
     * @return bool
     */
    public function approverUpdate($request, $qdn)
    {

		$user = $this->user()->employee;

        if ('reject' == $request->approver_radio)
        {
            $qdn->closure()->update(['status' => 'Incomplete Fill-Up', $user->department  => '']);
            return 'false';
        }

        $closure = [$user->department => $user->name];

        if(hasNoOtherDepartmentInvolve($user, $qdn)) $closure['other_Department'] = $user->name;
        $qdn->closure()->update($closure);

        $status['status'] = $this->statusOf($qdn) ? 'Q.a. Verification' : 'Incomplete Approval';
        $qdn->closure()->update($status);
        
        return 'true';
	}

    /**
     * @param $qdn
     * @return int
     */
    public function statusOf($qdn)
    {
		$closure     = Info::whereSlug($qdn->slug)->with('closure')->first();
		$closure = $closure->closure;
        $booleanClosure = $closure->other_department && $closure->production && $closure->quality_assurance && $closure->process_engineering;

        if ($booleanClosure && $qdn->status == 'Q.a. Verification')
            dd("InAppropriateClosureStatusException: QDN signatories is not yet complete and the status is already Q.a. Verification" . __LINE__);

        return $booleanClosure;
	}

    /**
     * @param $qdn
     * @param $request
     */
    public function sectionEightClosure($qdn, $request)
    {
		Closure::where('info_id', $qdn->id)
			->update([
				'containment_action_taken' => $request->containment_action_taken,
				'corrective_action_taken'  => $request->corrective_action_taken,
				'close_by'                 => $this->user()->employee->name,
				'date_sign'                => Carbon::now('Asia/Manila'),
				'status'                   => 'closed',
			]);

		$this->logEvent('Verify' . $qdn->control_id, $request->ValidationResult . ": " . $request->ApproverMessage);
		Event::fire(new QdnClosedNotificationEvent($qdn)); // send email notification

		Flash::success('Successfully updated! Issued QDN are now closed!'); // add flash alert notification
	}

    /**
     * @param $type
     * @param $qdn
     * @return mixed
     */
    public function count($type, $qdn)
    {
		return $qdn->where('failure_mode', $type)->count();
	}

    /**
     * @return mixed
     */
    public function getQdn()
    {
		$infoForMonth = Info::where(DB::raw('YEAR(created_at)'), $this->year())
			->where(DB::raw('MONTH(created_at)'), $this->month())
			->get();

		$infoForYear = Info::where(DB::raw('YEAR(created_at)'), $this->year())->get();

		return '' == $this->setMonth ? $infoForYear : $infoForMonth;
	}

    /**
     * @return mixed
     */
    public function failureModeCount()
    {
		$qdn = $this->getQdn();
        $counts = [];

		foreach ($this->failureMode() as $fm)
        {
			$counts[$fm] = count($qdn) ? $this->count($fm, $qdn) : 0;
		}
		return $counts;
	}

    /**
     * @return mixed
     */
    public function failureModeAve()
    {
		$qdn = $this->getQdn();
		$ave = $this->failureModeCount();

		if (array_sum($this->failureModeCount()))
        {
			foreach ($this->failureModeCount() as $key => $value)
            {
				$ave[$key] = round($this->count($key, $qdn) / array_sum($this->failureModeCount()) * 100);
			}
		}

		return $ave;
	}

    /**
     * @return array
     */
    public function failureMode()
    {
		$failure_mode = ['assembly', 'environment', 'machine', 'man', 'material', 'method / process'];
		$class        = new Str();

		return array_map([$class, 'title'], $failure_mode);
	}

    /**
     * @param $qdn
     */
    public function addCacheQdn($qdn)
    {
		Cache::add($qdn->slug, $this->user()->employee->name, 5);
	}

    /**
     * @param string $slug
     */
    public function forgetCache($slug = '')
    {
		if (Gate::allows('mod-qdn', $slug))
        {
			Cache::forget($slug);
		}
	}

	/**
	 * @param $event
	 * @internal param $qdn
	 * @internal param $request
	 */
	private function logEvent($event)
	{
		Event::fire(new EventLogs($event)); //event logs
	}

    /**
     * @param $msg
     */
    private function showMsg($msg)
    {
        Flash::success($msg);
    }

    /**
     * @param $request
     * @param $qdn
     */
    public function updateStatusEvent($request, $qdn)
    {
        $this->logEvent('view' . $qdn->control_id, $request->approver_radio . ": " . $request->ApproverMessage);
        Event::fire(new ApprovalNotificationEvent($qdn, $request->ApproverMessage)); //flash success alert message
        $this->showMsg('Successfully updated! Issued QDN still waiting for other approvers!');
    }


	private function update(ObjectiveEvidenceInterface $table, $info, $request)
    {
        $table->update($info, $request);
    }
}