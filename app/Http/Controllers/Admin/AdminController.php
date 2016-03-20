<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Models\Info;
use App\OptionModels\Machine;
use App\OptionModels\Option;
use App\repo\InfoRepository;
use Carbon;
use Illuminate\Http\Request;
use JavaScript;

class AdminController extends Controller {
	private $qdn;
	private $dt;

	public function __construct(InfoRepository $qdn) {
		$this->middleware('admin');
		$this->qdn        = $qdn;
		$this->dt         = Carbon::now('Asia/Manila');
		$this->qdn->month = $this->dt->format('m');
		$this->qdn->year  = $this->dt->format('Y');
	}

	public function index() {
		$ave   = $this->qdn->failureModeAve();
		$count = $this->qdn->failureModeCount();
		JavaScript::put('yearNow', $this->qdn->year);
		$qdn = Info::orderBy('id', 'desc')->take(5)->get()->load('closure');
		return view('admin.pages.index', compact('ave', 'qdn', 'count'));
	}
	public function MachineOptions() {
		$machines = Machine::all();
		JavaScript::put('machines', $machines);
		return view('admin.pages.machine', compact('machines'));
	}
	public function updateMachineOptions(Request $request) {
		$machine = Machine::whereName($request->name)->count();
		$res     = 'exist';
		if (0 == $machine) {
			$res = 'unique';
			Machine::create($request->all());
		}

		return $res;
	}
	public function removeMachineOptions(Request $request) {
		$machine = Machine::whereName($request->name)->delete();
		return 'Done';
	}
	public function CustomerOptions() {
		$customers = Option::all();
		JavaScript::put('customers', $customers);
		return view('admin.pages.customer', compact('customers'));
	}
	public function updateCustomerOptions(Request $request) {
		$customer = Option::whereCustomer($request->customer)->count();
		$res      = 'exist';
		if (0 == $customer) {
			$res = 'unique';
			Option::create($request->all());
		}

		return $res;
	}
	public function removeCustomerOptions(Request $request) {
		$customer = Option::whereCustomer($request->customer)->delete();
		return 'Done';
	}

	public function EmployeesOptions() {
		$employees = Employee::orderBy('user_id')->get()->load('user');
		// dd($employees->chunk(5)->chunk(5));
		JavaScript::put('employees', $employees);
		JavaScript::put('links', [
			'updateEmployee' => route('updateEmployeesOptions'),
			'removeEmployee' => route('removeEmployeesOptions'),
			'filterEmployee' => route('filterEmployeesOptions'),
		]);

		return view('admin.pages.employees', compact('employees'));
	}

	public function updateEmployeesOptions(Request $request) {
		$employee = Employee::whereEmployee($request->employee)->count();
		$res      = 'exist';
		if (0 == $employee) {
			$res = 'unique';
			Employee::create($request->all());
		}

		return $res;
	}
	public function removeEmployeeOptions(Request $request) {
		Employee::whereId($request->id)->delete();
		return 'Done';
	}

	public function UpdateLead(Request $request) {
		$this->qdn->month = $request->month;
		$this->qdn->year  = $request->year;

		$ave   = collect($this->qdn->failureModeAve())->toArray();
		$count = collect($this->qdn->failureModeCount())->toArray();
		return ['ave' => $ave, 'count' => $count];
	}
}
