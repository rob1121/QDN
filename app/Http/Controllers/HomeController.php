<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Closure;
use App\Models\Info;
use App\repo\HomeRepository;
use Auth;
use Illuminate\Http\Request;
use JavaScript;

class HomeController extends Controller {
	private $home;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(HomeRepository $home) {
		$this->home = $home;
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return Response
	 */
	public function index() {
		JavaScript::put('yearNow', $this->home->dateTime()->year);
		return view(Auth::user() ? 'home' : 'welcome');
	}

	/**
	 * array function for getting data for graphs
	 */
	protected function arrayCollection($collection) {
		return $this->home->collection($collection);
	}

	/**
	 * ajax call for highchart live update
	 * @return [type] [description]
	 */
	public function ajax(Request $request) {
		$arr = $this->home->highChartData($request);
		return $arr;
	}

	/**
	 * ajax call for qdn issuance updates
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function qdnData(Request $request) {
		$tbl = Info::issued($request->input('setDate'))->get();
		return view('home.qdnData', compact('tbl'));
	}

	/**
	 * ajax call for qdn issuance updates
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function AjaxStatus(Request $request) {
		$tbl = Closure::status($request->input('status'))->get();
		return view('home.status', compact('tbl'));
	}

	/**
	 * count data per graphs
	 * @return [type] [description]
	 */
	public function counter() {
		return $this->home->counter();
	}
}
