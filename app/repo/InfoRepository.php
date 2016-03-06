<?php
namespace App\repo;
use App\Employee;
use App\Models\CauseOfDefect;
use App\Models\Closure;
use App\Models\ContainmentAction;
use App\Models\CorrectiveAction;
use App\Models\Info;
use App\Models\InvolvePerson;
use App\Models\PreventiveAction;
use App\Models\QdnCycle;
use Auth;
use Carbon;
use JavaScript;

class InfoRepository implements InfoRepositoryInterface {

	public function view($qdn, $view) {
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

	public function save($info, $request) {
		$info->CauseOfDefect()->update([
			'cause_of_defect'             => $request->cause_of_defect,
			'cause_of_defect_description' => $request->cause_of_defect_description,
			'objective_evidence'          => $request->upload_cod,
		]);
		$info->ContainmentAction()->update([
			'what'               => $request->containment_action_textarea,
			'who'                => $request->containment_action_who,
			'objective_evidence' => $request->upload_containment_action,
		]);
		$info->CorrectiveAction()->update([
			'what'               => $request->corrective_action_textarea,
			'who'                => $request->corrective_action_who,
			'objective_evidence' => $request->upload_corrective_action,
		]);
		$info->PreventiveAction()->update([
			'what'               => $request->preventive_action_textarea,
			'who'                => $request->preventive_action_who,
			'objective_evidence' => $request->upload_preventive_action,
		]);
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
		$currentUser = Auth::user();
		foreach ($request->receiver_name as $name) {
			$person = Employee::findBy('name', $name)->first();

			InvolvePerson::create([
				'info_id'         => $id,
				'department'      => $person->department,
				'originator_id'   => $currentUser->employee_id,
				'originator_name' => $currentUser->employee->name,
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
			'pe_verified_by' => Auth::user()->employee->name,
		]);
	}

	public function approverUpdate($request, $qdn) {
		$user   = Auth::user()->employee;
		$column = str_replace(' ', '_', $user->department);
		$column = 'process' == $column ? 'process_engineering' : $column;
		$column = 'other' == $column ? 'other_department' : $column;
		$qdn->closure()->update([$column => $user->name]);

		if ('reject' == $request->approver_radio) {
			$qdn->closure()->update(['status' => 'incomplete fill-up']);
		} else {
			$this->updateStatus($qdn)
			? $qdn->closure()->update(['status' => 'incomplete approval'])
			: $qdn->closure()->update(['status' => 'q.a. verification']);
		}
	}

	public function updateStatus($qdn) {
		$qdn     = Info::whereSlug("test-only-msg")->with('closure')->first();
		$closure = $qdn->closure;
		return $closure->other_department && $closure->production && $closure->quality_assurance && $closure->process_engineering ? 0 : 1;
	}

	public function sectionEigthClosure($qdn, $request) {
		Closure::where('info_id', $qdn->id)
			->update([
				'containment_action_taken' => $request->containment_action_taken,
				'corrective_action_taken'  => $request->corrective_action_taken,
				'close_by'                 => Auth::user()->employee->name,
				'date_sign'                => Carbon::now('Asia/Manila'),
				'status'                   => 'closed',
			]);
	}
}