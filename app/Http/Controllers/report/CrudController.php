<?php

namespace App\Http\Controllers\report;

use App\Employee;
use App\Http\Controllers\Controller;
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

class CrudController extends Controller {

	public function save($slug, $request) {
		$info = Info::where('slug', $slug)->first();
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
		$currentUser = Auth::user();
		$currentYear = Carbon::now('Asia/Manila')->format('y');

		$lastIn     = Info::orderBy('id', 'desc')->first();
		$lastInYear = substr($lastIn->control_id, 0, 2);
		$lastInId   = substr($lastIn->control_id, 3);

		//control_id
		$control_id = $currentYear == $lastInYear
		? $lastInId + 1
		: 1;

		//customer
		$customer = $request->customer == "not yet specified"
		? $request->customerField
		: $request->customer;

		$info = Info::create([
			'control_id'           => $control_id,
			'customer'             => $customer,
			'package_type'         => $request->package_type,
			'device_name'          => $request->device_name,
			'lot_id_number'        => $request->lot_id_number,
			'lot_quantity'         => $request->lot_quantity,
			'job_order_number'     => $request->job_order_number,
			'machine'              => $request->machine,
			'station'              => $request->station,
			'major'                => $request->major,
			'disposition'          => '',
			'problem_description'  => $request->problem_description,
			'failure_mode'         => $request->failure_mode,
			'discrepancy_category' => $request->discrepancy_category,
			'quantity'             => $request->quantity,
		]);

		CauseOfDefect::create([
			'info_id'                     => $info->id,
			'cause_of_defect'             => '',
			'cause_of_defect_description' => '',
			'objective_evidence'          => '',
		]);

		CorrectiveAction::create([
			'info_id'            => $info->id,
			'what'               => '',
			'who'                => '',
			'objective_evidence' => '',
		]);

		ContainmentAction::create([
			'info_id'            => $info->id,
			'what'               => '',
			'who'                => '',
			'objective_evidence' => '',
		]);

		PreventiveAction::create([
			'info_id'            => $info->id,
			'what'               => '',
			'who'                => '',
			'objective_evidence' => '',
		]);

		foreach ($request->receiver_name as $name) {
			$person = Employee::findBy('name', $name)->first();

			InvolvePerson::create([
				'info_id'         => $info->id,
				'department'      => $person->department,
				'originator_id'   => $currentUser->employee_id,
				'originator_name' => $currentUser->employee->name,
				'receiver_id'     => $person->user_id,
				'receiver_name'   => $person->name,
			]);
		}

		Closure::create([
			'info_id'                  => $info->id,
			'containment_action_taken' => '',
			'corrective_action_taken'  => '',
			'close_by'                 => '',
			'date_sign'                => '',
			'production'               => '',
			'process_engineering'      => '',
			'quality_assurance'        => '',
			'other_department'         => '',
			'status'                   => 'p.e. verification',
		]);

		QdnCycle::create([
			'info_id'                        => $info->id,
			'cycle_time'                     => '',
			'production_cycle_time'          => '',
			'process_engineering_cycle_time' => '',
			'quality_assurance_cycle_time'   => '',
			'other_department_cycle_time'    => '',
		]);

	}

}
