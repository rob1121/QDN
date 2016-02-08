<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Info;
use Auth;
use Carbon;
use DB;
use Illuminate\Http\Request;
use JavaScript;

class ParetoController extends Controller {
	public $dateTime;

	public function __construct() {
		$this->middleware('auth');
		$this->dateTime = Carbon::now('Asia/Manila');
	}

	public function pareto(Request $request) {
		if (Auth::user()) {
			$month                 = Carbon::parse($request->input('month'))->format('m');
			$year                  = $request->input('year');
			$SelectedYear          = $request->input('year') ? $request->input('year') : $this->dateTime->format('Y');
			$FailureModes          = Info::select('failure_mode')->groupBy('failure_mode')->get();
			$DiscrepancyCategories = Info::select('discrepancy_category')->groupBy('discrepancy_category')->get();
			$discrepancy           = $request->input('discrepancy');
			$category              = $request->input('category');

			if ($category == 'total') {

				$table = Info::where(DB::raw('YEAR(created_at)'), $year)
					->where(DB::raw('MONTH(created_at)'), $month)
					->skip(0)
					->take(10)
					->get();

			} elseif ($category == 'failureMode' || $category == 'fmTotal') {

				$table = Info::where(DB::raw('YEAR(created_at)'), $year)
					->where(DB::raw('MONTH(created_at)'), $month)
					->where('failure_mode', $discrepancy)
					->skip(0)
					->take(10)
					->get();

			} elseif (($category == 'pod')) {

				$table = Info::where(DB::raw('YEAR(created_at)'), $year)
					->where('discrepancy_category', $discrepancy)
					->skip(0)
					->take(10)
					->get();

			} elseif ($category == 'today') {

				$table = Info::where(
					DB::raw('DATE_FORMAT(created_at, "%m-%d-%Y")'),
					"=",
					$this->dateTime->format('m-d-Y')
				)
					->skip(0)
					->take(10)
					->get();

			} elseif ($category == 'week') {

				$table = Info::where(
					DB::raw('WEEK(created_at)'),
					"=",
					$this->dateTime->weekOfYear
				)
					->skip(0)
					->take(10)
					->get();

			} elseif ($category == 'month') {

				$table = Info::where(
					DB::raw('MONTH(created_at)'),
					"=",
					$this->dateTime->month
				)
					->where(
						DB::raw('YEAR(created_at)'),
						"=",
						$this->dateTime->year
					)
					->skip(0)
					->take(10)
					->get();

			} elseif ($category == 'year') {
				$table = Info::where(
					DB::raw('YEAR(created_at)'),
					"=",
					$this->dateTime->year
				)
					->skip(0)
					->take(10)
					->get();

			} else {

				$table = Info::where(DB::raw('YEAR(created_at)'), $year)
					->where(DB::raw('MONTH(created_at)'), $month)
					->where('discrepancy_category', $discrepancy)
					->skip(0)
					->take(10)
					->get();

			}
			JavaScript::put('discrepancy', $discrepancy);
			JavaScript::put('category', $category);
			return view('home.pareto', compact('table', 'SelectedYear', 'FailureModes', 'DiscrepancyCategories'));
		}
	}

	public function paretoAjax(Request $request) {
		$start       = $request->input('start');
		$end         = $request->input('end');
		$year        = $request->input('year');
		$month       = $request->input('month');
		$column      = $request->input('column');
		$sort        = $request->input('sort');
		$discrepancy = $request->input('discrepancy');
		$FailureMode = $request->input('FailureMode');

		$condition = $month == '' ? 'LIKE' : '=';
		$month     = $month == '' ? '%' . $month . '%' : $month;

		$tbl = info::orderBy($column, $sort)
			->where(DB::raw('YEAR(created_at)'), 'LIKE', '%' . $year . '%')
			->where(DB::raw('MONTH(created_at)'), $condition, $month)
			->where('discrepancy_category', 'LIKE', '%' . $discrepancy . '%')
			->where('failure_mode', 'LIKE', '%' . $FailureMode)
			->skip($request->input('start'))
			->take($request->input('end'))
			->get();

		return view('home.pareto-ajax', compact('tbl', 'option', 'sort', 'column'));

	}
}
