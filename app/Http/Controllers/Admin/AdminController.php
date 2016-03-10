<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Info;

class AdminController extends Controller {
	public function __construct() {
		$this->middleware('admin');
	}
	public function index() {
		$qdn = Info::select('failure_mode')->groupBy('failure_mode')->get();

		return view('admin.pages.index', compact('qdn', 'count'));
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
}
