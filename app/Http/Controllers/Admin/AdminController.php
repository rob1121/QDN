<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Info;
use App\repo\InfoRepository;
use Carbon;
use Illuminate\Http\Request;
use JavaScript;

class AdminController extends Controller {
	private $qdn;
	private $dt;

	public function __construct(InfoRepository $qdn) {
		$this->middleware('admin');
		$this->qdn           = $qdn;
		$this->dt            = Carbon::now('Asia/Manila');
		$this->qdn->setMonth = $this->dt->format('m');
		$this->qdn->setYear  = $this->dt->format('Y');
	}

	public function index() {
		$ave   = $this->qdn->failureModeAve();
		$count = $this->qdn->failureModeCount();
		JavaScript::put('yearNow', $this->qdn->year());
		$qdn = Info::orderBy('id', 'desc')->take(5)->get()->load('closure');
		return view('admin.pages.index', compact('ave', 'qdn', 'count'));
	}

	public function UpdateLead(Request $request) {
		$this->qdn->setMonth = $request->month;
		$this->qdn->setYear  = $request->year;

		$ave   = collect($this->qdn->failureModeAve())->toArray();
		$count = collect($this->qdn->failureModeCount())->toArray();
		return ['ave' => $ave, 'count' => $count];
	}
}
