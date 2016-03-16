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
use Cache;
use Carbon;
use DB;
use Event;
use Flash;
use JavaScript;
use Storage;
use Str;

class InfoRepository implements InfoRepositoryInterface {
	public $month;
	public $year;
	public $user;

	public function view($qdn, $view) {
		Event::fire(new EventLogs('view' . $qdn->control_id));
		JavaScript::put('link', $this->links($qdn->slug));
		JavaScript::put('qdn', $qdn);
		return view($view, compact('qdn'));
	}

	public function links($slug) {
		return [
			'linkDraft'    => route('draft_link', ['slug' => $slug]),
			'linkApproval' => route('approval_link', ['slug' => $slug]),
		];
	}
	public function updateCauseOfDefect($info, $request) {
		$year = Carbon::parse($info->created_at)->year;
		if ($request->hasFile('upload_cod')) {
			if ("" != $info->causeOfDefect->objective_evidence) {
				$existing_oe = 'objective_evidence/' . $year . '/' . $info->control_id . '/' . $info->causeOfDefect->objective_evidence;
				if (Storage::disk('local')->exists($existing_oe)) {
					Storage::delete($existing_oe);
				}
			}

			$path      = public_path() . "/objective_evidence/" . $year . "/" . $info->control_id . "/";
			$file_name = 'upload_cod' . "." . $request->file('upload_cod')->guessClientExtension();
			$request->file('upload_cod')->move($path, $file_name);
		}

		$objective_evidence = isset($file_name) ? $file_name : $info->CauseOfDefect->objective_evidence;
		$info->CauseOfDefect()->update([
			'cause_of_defect'             => $request->cause_of_defect,
			'cause_of_defect_description' => $request->cause_of_defect_description,
			'objective_evidence'          => $objective_evidence,
		]);
	}
	public function updateContainmentAction($info, $request) {
		$year = Carbon::parse($info->created_at)->year;
		if ($request->hasFile('upload_containment_action')) {
			if ("" != $info->containmentAction->objective_evidence) {
				$existing_oe = 'objective_evidence/' . $year . '/' . $info->control_id . '/' . $info->containmentAction->objective_evidence;
				if (Storage::disk('local')->exists($existing_oe)) {
					Storage::delete($existing_oe);
				}
			}

			$path      = public_path() . "/objective_evidence/" . $year . "/" . $info->control_id . "/";
			$file_name = 'upload_containment_action' . "." . $request->file('upload_containment_action')->guessClientExtension();
			$request->file('upload_containment_action')->move($path, $file_name);
		}

		$objective_evidence = isset($file_name) ? $file_name : $info->containmentAction->objective_evidence;
		$info->ContainmentAction()->update([
			'what'               => $request->containment_action_textarea,
			'who'                => $request->containment_action_who,
			'objective_evidence' => $objective_evidence,
		]);
	}
	public function updateCorrectiveAction($info, $request) {
		$year = Carbon::parse($info->created_at)->year;
		if ($request->hasFile('upload_corrective_action')) {
			if ("" != $info->correctiveAction->objective_evidence) {
				$existing_oe = 'objective_evidence/' . $year . '/' . $info->control_id . '/' . $info->correctiveAction->objective_evidence;
				if (Storage::disk('local')->exists($existing_oe)) {
					Storage::delete($existing_oe);
				}
			}

			$path      = public_path() . "/objective_evidence/" . $year . "/" . $info->control_id . "/";
			$file_name = 'upload_corrective_action' . "." . $request->file('upload_corrective_action')->guessClientExtension();
			$request->file('upload_corrective_action')->move($path, $file_name);
		}

		$objective_evidence = isset($file_name) ? $file_name : $info->correctiveAction->objective_evidence;
		$info->CorrectiveAction()->update([
			'what'               => $request->corrective_action_textarea,
			'who'                => $request->corrective_action_who,
			'objective_evidence' => $objective_evidence,
		]);
	}
	public function updatePreventiveAction($info, $request) {
		$year = Carbon::parse($info->created_at)->year;
		if ($request->hasFile('upload_preventive_action')) {
			if ("" != $info->preventiveAction->objective_evidence) {
				$existing_oe = 'objective_evidence/' . $year . '/' . $info->control_id . '/' . $info->preventiveAction->objective_evidence;
				if (Storage::disk('local')->exists($existing_oe)) {
					Storage::delete($existing_oe);
				}
			}

			$path      = public_path() . "/objective_evidence/" . $year . "/" . $info->control_id . "/";
			$file_name = 'upload_preventive_action' . "." . $request->file('upload_preventive_action')->guessClientExtension();
			$request->file('upload_preventive_action')->move($path, $file_name);
		}

		$objective_evidence = isset($file_name) ? $file_name : $info->preventiveAction->objective_evidence;
		$info->PreventiveAction()->update([
			'what'               => $request->preventive_action_textarea,
			'who'                => $request->preventive_action_who,
			'objective_evidence' => $objective_evidence,
		]);
	}

	public function save($info, $request) {
		$this->updateCauseOfDefect($info, $request);
		$this->updateContainmentAction($info, $request);
		$this->updateCorrectiveAction($info, $request);
		$this->updatePreventiveAction($info, $request);

	}

	public function add($request) {
		$info = $this->AddInfo($request);
		$id   = ['info_id' => $info->id];

		$this->AddInvolvePerson($request, $info->id);
		CauseOfDefect::create($id);
		CorrectiveAction::create($id);
		ContainmentAction::create($id);
		PreventiveAction::create($id);
		QdnCycle::create($id);
		Closure::create(['info_id' => $info->id, 'status' => 'p.e. verification']);
		return $info;
	}

	public function AddInfo($request) {
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

	public function AddInvolvePerson($request, $id) {
		foreach ($request->receiver_name as $name) {
			$person = Employee::findBy('name', $name)->first();

			InvolvePerson::create([
				'info_id'         => $id,
				'department'      => $person->department,
				'originator_id'   => $this->user->employee_id,
				'originator_name' => $this->user->employee->name,
				'receiver_id'     => $person->user_id,
				'receiver_name'   => $person->name,
			]);
		}
	}

	public function SectionOneUpdate($request, $slug) {
		$slug->update($request->all());
		$arr_names     = [];
		$involvePerson = $slug->involvePerson()->first();
		$emp_dept      = [];
		foreach (array_unique($request->receiver_name) as $name) {
			$emp         = Employee::whereName($name)->first();
			$emp_dept[]  = $emp->station;
			$arr_names[] = new InvolvePerson([
				'department'      => $emp->station,
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

	public function UpdateClosureStatus($request, $qdn) {
		$qdn->closure()->update([
			'status'         => $request->status,
			'pe_verified_by' => $this->user->employee->name,
		]);
		Event::fire(new EventLogs('P.E. validate' . $qdn->control_id, $request->status . ": " . $request->ValidationMessage));
		Event::fire(new PeVerificationNotificationEvent($qdn, $request->ValidationMessage));
		Flash::success('Successfully Verified !! QDN are now ready for completion!');
	}

	public function approverUpdate($request, $qdn) {
		$this->user = $this->user->employee;
		$qdn->closure()->update([$this->user->department => $this->user->name]);

		if ('reject' == $request->approver_radio) {
			$qdn->closure()->update([
				'status' => 'Incomplete Fill-Up',
				$column  => '',
			]);
		} else {
			$this->updateStatus($qdn)
			? $qdn->closure()->update(['status' => 'Incomplete Approval'])
			: $qdn->closure()->update(['status' => 'Q.a. Verification']);
		}
		Event::fire(new EventLogs('view' . $qdn->control_id, $request->approver_radio . ": " . $request->ApproverMessage)); //fire email notif event
		Event::fire(new ApprovalNotificationEvent($qdn, $request->ApproverMessage)); //flash success alert message
		Flash::success('Successfully updated! Issued QDN still waiting for other approvers!'); //return home page
	}

	public function updateStatus($qdn) {
		$qdn     = Info::whereSlug($qdn->slug)->with('closure')->first();
		$closure = $qdn->closure;
		return $closure->other_department && $closure->production && $closure->quality_assurance && $closure->process_engineering ? 0 : 1;
	}

	public function sectionEigthClosure($qdn, $request) {
		Closure::where('info_id', $qdn->id)
			->update([
				'containment_action_taken' => $request->containment_action_taken,
				'corrective_action_taken'  => $request->corrective_action_taken,
				'close_by'                 => $this->user->employee->name,
				'date_sign'                => Carbon::now('Asia/Manila'),
				'status'                   => 'closed',
			]);

		Event::fire(new EventLogs('Verify' . $qdn->control_id, $request->ValidationResult . ": " . $request->ApproverMessage)); //event logs
		Event::fire(new QdnClosedNotificationEvent($qdn)); // send email notification
		Flash::success('Successfully updated! Issued QDN are now closed!'); // add flash alert notification
	}
	/**
	 * return counts of defined failure mode
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	public function count($type, $qdn) {

		return $qdn->where('failure_mode', $type)->count();
	}

	public function getQdn() {
		if ('' != $this->month) {
			return Info::where(DB::raw('YEAR(created_at)'), $this->year)
				->where(DB::raw('MONTH(created_at)'), $this->month)
				->get();
		} else {
			return Info::where(DB::raw('YEAR(created_at)'), $this->year)->get();
		}
	}
	/**
	 * return counts of failure mode
	 * @return [type] [description]
	 */
	public function failureModeCount() {
		$qdn = $this->getQdn();
		foreach ($this->failureMode() as $fm) {
			$counts[$fm] = $this->count($fm, $qdn);
		}
		return $counts;
	}

	/**
	 * return counts of failure mode
	 * @return [type] [description]
	 */
	public function failureModeAve() {
		$qdn = $this->getQdn();
		if (array_sum($this->failureModeCount())) {
			foreach ($this->failureModeCount() as $key => $value) {
				$ave[$key] = round($this->count($key, $qdn) / array_sum($this->failureModeCount()) * 100);
			}
			return $ave;
		}
	}

	public function failureMode() {
		$failure_mode = ['assembly', 'environment', 'machine', 'man', 'material', 'method / process'];
		$class        = new Str();
		return array_map([$class, 'title'], $failure_mode);
	}

	public function cacheQdn($qdn) {
		if (!Cache::get($qdn->slug)) {
			Cache::add($qdn->slug, $this->user->employee->name, 5);
		}
		return Cache::get($qdn->slug);
	}
}