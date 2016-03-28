<?php

namespace App\Http\Controllers\Admin\Option;

use App\Http\Controllers\Controller;
use App\repo\Option\DiscrepancyRepo;
use Illuminate\Http\Request;

class DiscrepancyController extends Controller {
	private $discrepancy;

	public function __construct(DiscrepancyRepo $discrepancy) {
		$this->middleware('admin');
		$this->discrepancy = $discrepancy;
	}

	public function discrepancy() {
		$this->discrepancy->setup();
		return view('admin.pages.discrepancy');
	}

	public function updateDiscrepancy(Request $request) {
		return $this->discrepancy->update($request);
	}

	public function removeDiscrepancy(Request $request) {
		$this->discrepancy->delete($request->name);
	}
}
