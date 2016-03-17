<?php

namespace App\repo;

use App\Models\Closure;
use App\Models\Info;
use Carbon;
use DB;

class HomeRepository {

	public function dateTime() {
		return Carbon::now('Asia/Manila');
	}
	public function collection($collection) {
		$arr        = [];
		$legend     = 'A';
		$collectors = 0;

		foreach ($collection as $elem) {

			$collectors += $elem->paretoFirst;
			$arr['legends'][]  = $legend++;
			$arr['lines'][]    = $collectors;
			$arr['bars'][]     = $elem->paretoFirst;
			$arr['category'][] = $elem->category;
		}

		$arr['total'] = isset($arr['bars']) ? array_sum($arr['bars']) : 0;
		return $arr;
	}

	public function highChartData($request) {
		// $month = $this->dateTime()->format('m') == $request->input('month')
		// ? $request->input('month')
		// : Carbon::parse($request->input('month'))->format('m');
		$month = $request->input('month');
		$year  = $request->input('year');

		//retrieve data collection
		$info        = Info::qdn($year)->get();
		$pod         = Info::pod($month, $year, '');
		$failureMode = Info::pod($month, $year, 'failureMode');
		$assembly    = Info::pod($month, $year, 'assembly');
		$environment = Info::pod($month, $year, 'environment');
		$machine     = Info::pod($month, $year, 'machine');
		$man         = Info::pod($month, $year, 'man');
		$material    = Info::pod($month, $year, 'material');
		$process     = Info::pod($month, $year, 'method / process');

		$arr = ['qdn' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]];

		foreach ($info as $elem) {
			$arr['qdn'][$elem->month - 1] = round($elem->count / 4);
		}

		$arr['pod']         = $this->collection($pod);
		$arr['failureMode'] = $this->collection($failureMode);
		$arr['assembly']    = $this->collection($assembly);
		$arr['environment'] = $this->collection($environment);
		$arr['machine']     = $this->collection($machine);
		$arr['man']         = $this->collection($man);
		$arr['material']    = $this->collection($material);
		$arr['process']     = $this->collection($process);

		return $arr;
	}

	public function counter() {
		$date  = $this->dateTime();
		$qdn   = Info::whereYear('created_at', '=', $date->year)->get();
		$month = Info::whereMonth('created_at', '=', $date->month)->count();
		$today = Info::whereDate('created_at', '=', $date->format('Y-m-d'))->count();
		$week  = Info::where(DB::raw('WEEK(created_at)'), $date->weekOfYear)->count();
		$year  = $qdn->count();

		$closure        = Closure::all();
		$peVerification = $closure->where('status', 'P.e. Verification')->count();
		$incomplete     = $closure->where('status', 'Incomplete Fill-Up')->count();
		$approval       = $closure->where('status', 'Incomplete Approval')->count();
		$qaVerification = $closure->where('status', 'Q.a. Verification')->count();

		return $arr = [
			'today'          => $today,
			'week'           => $week,
			'year'           => $year,
			'PeVerification' => $peVerification,
			'Incompomplete'  => $incomplete,
			'Approval'       => $approval,
			'QaVerification' => $qaVerification,
		];
	}

}