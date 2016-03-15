<?php

namespace App\Http\Controllers\Admin;

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

	public function QdnMetrics() {
		return view('admin.main');
	}
	public function ParetoOfDiscrepancy() {
		return view('admin.main');
	}
	public function ParetoPerFailureMode() {
		return view('admin.main');
	}
	public function MachineOptions() {
		$machines = Machine::all();
		JavaScript::put('machines', $machines);
		return view('admin.pages.machine', compact('machines'));
	}
	public function updateMachineOptions(Request $request, $machine) {
		$machine = Machine::whereMachine($machine)->first();
		$machine->count()
		? $machine->update($request->all())
		: $machine->create($request->all());
		return "all";
	}
	public function FailureModeOptions() {
		return view('admin.main');
	}
	public function DiscrepancyCategoryOptions() {
		return view('admin.main');
	}
	public function CustomerOptions() {
		$customers = Option::all();
		JavaScript::put('customers', $customers);
		return view('admin.pages.customer', compact('customers'));
	}

	public function UpdateLead(Request $request) {
		$this->qdn->month = $request->month;
		$this->qdn->year  = $request->year;

		$ave   = collect($this->qdn->failureModeAve())->toArray();
		$count = collect($this->qdn->failureModeCount())->toArray();
		return ['ave' => $ave, 'count' => $count];
	}
}
