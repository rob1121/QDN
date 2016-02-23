<?php

namespace App\Http\Controllers;

use App\Events\EmailQdnNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Closure;
use App\Models\Info;
use Auth;
use Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use JavaScript;

class HomeController extends Controller {

	public $dateTime;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	public function __construct() {
		$this->dateTime = Carbon::now('Asia/Manila');
		// $this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return Response
	 */
	public function index() {
		if (Auth::user()) {
			JavaScript::put('yearNow', $this->dateTime->year);
			Event::fire(new EmailQdnNotificationEvent());
			return view('home');
		}
		return view('welcome');

	}

	/**
	 * array function for getting data for graphs
	 */
	protected function arrayCollection($collection) {
		$arr = [];
		$legend = 'A';
		$collectors = 0;

		foreach ($collection as $elem) {

			$collectors += $elem->paretoFirst;
			$arr['legends'][] = $legend++;
			$arr['lines'][] = $collectors;
			$arr['bars'][] = $elem->paretoFirst;
			$arr['category'][] = $elem->category;

		}
		$arr['total'] = 0;

		if (isset($arr['bars'])) {
			$arr['total'] = array_sum($arr['bars']);
		}

		return $arr;
	}

	/**
	 * ajax call for highchart live update
	 * @return [type] [description]
	 */
	public function ajax(Request $request) {
		//date
		$month = Carbon::parse($request->input('month'))->format('m');
		$year = $request->input('year');

		//retrieve data collection
		$info = Info::qdn($year)->get();
		$pod = Info::pod($month, $year, '');
		$failureMode = Info::pod($month, $year, 'failureMode');
		$assembly = Info::pod($month, $year, 'assembly');
		$environment = Info::pod($month, $year, 'environment');
		$machine = Info::pod($month, $year, 'machine');
		$man = Info::pod($month, $year, 'man');
		$material = Info::pod($month, $year, 'material');
		$process = Info::pod($month, $year, 'method / process');

		$arr = ['qdn' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]];

		foreach ($info as $elem) {
			$arr['qdn'][$elem->month - 1] = round($elem->count / 4);
		}

		$arr['pod'] = $this->arrayCollection($pod);
		$arr['failureMode'] = $this->arrayCollection($failureMode);
		$arr['assembly'] = $this->arrayCollection($assembly);
		$arr['environment'] = $this->arrayCollection($environment);
		$arr['machine'] = $this->arrayCollection($machine);
		$arr['man'] = $this->arrayCollection($man);
		$arr['material'] = $this->arrayCollection($material);
		$arr['process'] = $this->arrayCollection($process);

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

		$qdn = Info::whereYear('create_at', $this->dateTime->year)->get();
		$year = $qdn->count();
		$month = $qdn->whereMonth('create_at', $this->dateTime->month)->count();
		$week = $qdn->where(DB::raw('WEEK(created_at)'), $this->dateTime->weekOfYear)->count();
		$today = $qdn->whereDate('create_at', $this->dateTime->format('Y-m-d'))->count();

		$closure = Closure::all();
		$peVerification = $closure->whereStatus('p.e. verification')->count();
		$incomplete = $closure->whereStatus('incomplete fill-up')->count();
		$approval = $closure->whereStatus('incomplete approval')->count();
		$qaVerification = $closure->whereStatus('q.a. verification')->count();

		$arr = [
			'today' => $today,
			'week' => $week,
			'year' => $year,
			'PeVerification' => $peVerification,
			'Incompomplete' => $incomplete,
			'Approval' => $approval,
			'QaVerification' => $qaVerification,
		];

		return $arr;
	}
}
