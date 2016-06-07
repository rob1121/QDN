<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Info;
use App\repo\InfoRepository;
use App\repo\Traits\DateTime;
use Carbon;
use Illuminate\Http\Request;
use JavaScript;

class AdminController extends Controller {
	use DateTime;
	private $qdn;

	public function __construct(InfoRepository $qdn) {
		$this->middleware('admin');
		$this->qdn = $qdn;
	}

	public function index() {
		JavaScript::put('yearNow', $this->year());
		return view('admin.pages.index')
            ->with([
                'ave' => $this->qdn->failureModeAve(),
                'qdn' => Info::orderBy('id', 'desc')->take(5)->get()->load('closure'),
                'count' => $this->qdn->failureModeCount()
            ]);
	}

	public function UpdateLead(Request $request) {
		$this->qdn->setMonth = $request->month;
		$this->qdn->setYear  = $request->year;

		$ave   = collect($this->qdn->failureModeAve())->toArray();
		$count = collect($this->qdn->failureModeCount())->toArray();
		return ['ave' => $ave, 'count' => $count];
	}
}
