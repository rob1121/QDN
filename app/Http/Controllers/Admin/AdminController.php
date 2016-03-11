<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\repo\InfoRepository;
use Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller {
	private $qdn;
	private $dt;

	public function __construct(InfoRepository $qdn) {
		$this->middleware('admin');
		$this->qdn = $qdn;
		$this->dt  = Carbon::now('Asia/Manila');
	}
	public function index() {
		$this->qdn->month = $this->dt->format('m');
		$this->qdn->year  = $this->dt->format('Y');
		$ave              = $this->qdn->failureModeAve();
		return view('admin.pages.index', compact('ave'));
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
		return view('admin.main');
	}
	public function FailureModeOptions() {
		return view('admin.main');
	}
	public function DiscrepancyCategoryOptions() {
		return view('admin.main');
	}
	public function CustomerOptions() {
		return view('admin.main');
	}

	public function UpdateLead(Request $request) {
		$this->qdn->month = $request->month;
		$this->qdn->year  = $request->year;
		return collect($this->qdn->failureModeAve())->toArray();
	}
}
