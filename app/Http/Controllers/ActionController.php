<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Models\Info;
use App\Models\InvolvePerson;
use Illuminate\Http\Request;

class ActionController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function SectionOneUpdate($request, $slug) {
		$slug->update($request->all());
		$arr_names     = [];
		$involvePerson = $slug->involvePerson()->first();
		$emp_dept      = [];
		foreach (array_unique($request->receiver_name) as $name) {
			$emp         = Employee::where('name', $name)->first();
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

	public function SectionOneSaveAndProceed(Request $request, Info $slug) {
		$this->SectionOneUpdate($request, $slug);
		$slug->closure()->update(['status' => $request->status]);
		return redirect('/');
		// return $request->all();

	}
	public function SectionOneSaveAsDraft(Request $request, Info $slug) {
		$collection = $this->SectionOneUpdate($request, $slug);
		return array_add($request->all(), 'department', $collection['emp_dept']);
	}

	public function ForIncompleteFillUp(Info $slug) {
		$qdn        = $slug;
		$department = $qdn->involvePerson()
			->select('department')
			->get()
			->toArray();

		$department = array_unique(array_flatten($department));
		return view('report.incomplete', compact('qdn', 'department'));
	}

}
