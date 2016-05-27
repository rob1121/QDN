<?php

namespace App\Http\Controllers;

use App\Models\Info;
use app\repo\ParetoRepository;
use Auth;
use Carbon;
use DB;
use Illuminate\Http\Request;
use JavaScript;

class ParetoController extends Controller {
	public $dateTime;
    /**
     * @var ParetoRepository
     */
    private $pareto;

    /**
     * ParetoController constructor.
     * @param ParetoRepository $pareto
     */
    public function __construct(ParetoRepository $pareto) {
		$this->middleware('admin');
		$this->dateTime = Carbon::now('Asia/Manila');
        $this->pareto = $pareto;
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
                    'table' => $this->post->selectCategory($request),
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
