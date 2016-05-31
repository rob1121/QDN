<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\repo\ParetoRepository;
use Auth;
use Carbon;
use DB;
use Illuminate\Http\Request;
use JavaScript;

class ParetoController extends Controller {
    private $pareto;

    /**
     * ParetoController constructor.
     * @param ParetoRepository $pareto
     */
    public function __construct(ParetoRepository $pareto) {
		$this->middleware('admin');
        $this->pareto = $pareto;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pareto(Request $request)
    {
        $this->jsVariables($request);

        $collections = [
            'table' => $this->pareto->selectCategory($request),
            'SelectedYear' => $request->year ? $request->year : $this->dateTime()->format('Y'),
            'FailureModes' => Info::select('failure_mode')->groupBy('failure_mode')->get(),
            'DiscrepancyCategories' => Info::select('discrepancy_category')->groupBy('discrepancy_category')->get()
        ];

        return view('home.pareto', $collections);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paretoAjax(Request $request) {

        $collections = [
            'column' => $request->column,
            'tbl' => $this->filterInfo($request),
            'sort' => $request->sort
        ];

        return view('home.pareto-ajax', $collections);

	}

    /**
     * @param Request $request
     */
    private function jsVariables($request)
    {
        $collections = [
            'discrepancy', $request->discrepancy,
            'category', $request->category
        ];

        JavaScript::put($collections);
    }

    /**
     * @param $request
     * @return mixed
     */
    private function filterInfo($request)
    {
        return '' != $request->text
            ? $this->filterWithText($request)
            : $this->filterWithoutText($request);
    }

    /**
     * @return mixed
     */
    private function dateTime()
    {
        return Carbon::now('Asia/Manila');
    }

    /**
     * @param $request
     * @return mixed
     */
    private function filterWithText($request)
    {
        return Info::orderBy($request->column, $request->sort)
            ->where(DB::raw('YEAR(created_at)'), 'LIKE', "%" . $request->year . "%")
            ->search($request->text)
            ->show($request->start, $request->end)
            ->get();
    }

    /**
     * @param $request
     * @return mixed
     */
    private function filterWithoutText($request)
    {
        $condition = '' == $request->month ? 'LIKE' : '=';
        $month = '' == $request->month ? '%' . $request->month . '%' : $request->month;

        $option = Info::orderBy($request->column, $request->sort)
            ->where(DB::raw('YEAR(created_at)'), 'LIKE', '%' . $request->year . '%')
            ->where(DB::raw('MONTH(created_at)'), $condition, $month)
            ->where('discrepancy_category', 'LIKE', '%' . $request->discrepancy . '%')
            ->where('failure_mode', 'LIKE', '%' . $request->FailureMode)
            ->show($request->start, $request->end)
            ->get();

        return $option;
    }
}
