<?php

namespace App\Http\Controllers\Admin\Option;

use App\Employee;
use App\Http\Controllers\Controller;
use App\OptionModels\Station;
use App\repo\InfoRepository;
use App\repo\Option\EmployeeRepo;
use App\User;
use Carbon;
use Illuminate\Http\Request;
use Validator;
use JavaScript;

class EmployeeController extends Controller {
	private $employee;

	public function __construct(EmployeeRepo $employee) {
		$this->middleware('admin');
		$this->employee = $employee;
	}

	public function EmployeesOptions() {
		return view('admin.pages.employees')
			->with('employees',$this->employee->setup())
			->with('stations',Station::all());
	}

	public function newEmployeesOptions(Request $request) {
		return $this->employee->stores($request);
	}

	public function updateEmployeesOptions(Request $request) {
		return $this->employee->updates($request);
	}

	public function removeEmployeesOptions(Request $request) {
		$this->employee->delete($request->id);
	}
}
