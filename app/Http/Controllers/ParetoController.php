<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Auth;
use Carbon;
use DB;
use Illuminate\Http\Request;
use JavaScript;

class ParetoController extends Controller {
	public $dateTime;

	public function __construct() {
		$this->middleware('admin');
		$this->dateTime = Carbon::now('Asia/Manila');
	}

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pareto(Request $request)
    {
        $this->jsVariables($request);

        return view('home.pareto',
                [
                    'table' => $this->selectCategory($request),
                    'SelectedYear' => $request->year ? $request->year : $this->dateTime->format('Y'),
                    'FailureModes' => Info::select('failure_mode')->groupBy('failure_mode')->get(),
                    'DiscrepancyCategories' => Info::select('discrepancy_category')->groupBy('discrepancy_category')->get()
                ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paretoAjax(Request $request) {

		return view('home.pareto-ajax',[
            'column' => $request->column,
            'tbl' => $this->filterInfo($request),
            'sort' => $request->sort
        ]);

	}

    /**
     * @param $request
     * @return mixed
     */
    private function selectCategory($request)
	{
        $month = Carbon::parse($request->month)->format('m');
		if ('total' == $request->category) {

			$table = Info::with(['involvePerson'])->where(DB::raw('YEAR(created_at)'), $this->year)
				->where(DB::raw('MONTH(created_at)'), $month)
				->show(0, 10)
				->get();
			return $table;

		} elseif ('failureMode' == $request->category || 'fmTotal' == $request->category) {

			$table = Info::with(['involvePerson'])->where(DB::raw('YEAR(created_at)'), $this->year)
				->where(DB::raw('MONTH(created_at)'), $month)
				->where('failure_mode', $request->discrepancy)
				->show(0, 10)
				->get();
			return $table;

		} elseif (('pod' == $request->category)) {

			$table = Info::with(['involvePerson'])->where(DB::raw('YEAR(created_at)'), $this->year)
				->where('discrepancy_category', $request->discrepancy)
				->show(0, 10)
				->get();
			return $table;

		} elseif ('today' == $request->category) {

			$table = Info::with(['involvePerson'])->where(
				DB::raw('DATE_FORMAT(created_at, "%m-%d-%Y")'),
				"=",
				$this->dateTime->format('m-d-Y')
			)
				->show(0, 10)
				->get();
			return $table;

		} elseif ('week' == $request->category) {

			$table = Info::with(['involvePerson'])->where(
				DB::raw('WEEK(created_at)'),
				"=",
				$this->dateTime->weekOfYear
			)
				->show(0, 10)
				->get();
			return $table;

		} elseif ('month' == $request->category) {

			$table = Info::with(['involvePerson'])->where(
				DB::raw('MONTH(created_at)'),
				"=",
				$this->dateTime->month
			)
				->where(
					DB::raw('YEAR(created_at)'),
					"=",
					$this->dateTime->year
				)
				->show(0, 10)
				->get();
			return $table;

		} elseif ('year' == $request->category) {
			$table = Info::with(['involvePerson'])->where(
				DB::raw('YEAR(created_at)'),
				"=",
				$this->dateTime->year
			)
				->show(0, 10)
				->get();
			return $table;

		} else {

			$table = Info::with(['involvePerson'])->where(DB::raw('YEAR(created_at)'), $this->year)
				->where(DB::raw('MONTH(created_at)'), $month)
				->where('discrepancy_category', $request->discrepancy)
				->show(0, 10)
				->get();
			return $table;

		}
	}

    /**
     * @param Request $request
     */
    private function jsVariables($request)
    {
        JavaScript::put([
            'discrepancy', $request->discrepancy,
            'category', $request->category
        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    private function filterInfo($request)
    {
        $condition = '' == $request->month ? 'LIKE' : '=';
        $month     = '' == $request->month ? '%' . $request->month . '%' : $request->month;

        return '' != $request->text
            ? Info::orderBy($request->column, $request->sort)
                ->where(DB::raw('YEAR(created_at)'), 'LIKE', "%" . $request->year . "%")
                ->search($request->text)
                ->show($request->start, $request->end)
                ->get()

            : Info::orderBy($request->column, $request->sort)
                ->where(DB::raw('YEAR(created_at)'), 'LIKE', '%' . $request->year . '%')
                ->where(DB::raw('MONTH(created_at)'), $condition, $month)
                ->where('discrepancy_category', 'LIKE', '%' . $request->discrepancy . '%')
                ->where('failure_mode', 'LIKE', '%' . $request->FailureMode)
                ->show($request->start, $request->end)
                ->get();
    }
}
