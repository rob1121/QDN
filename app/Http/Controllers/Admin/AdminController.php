<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller {
	public function __construct() {
		$this->middleware('admin');
	}
	public function index() {
		return view('admin.main');
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
