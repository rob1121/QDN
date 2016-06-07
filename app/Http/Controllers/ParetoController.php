<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\repo\ParetoRepository;
use App\repo\Traits\DateTime;
use Carbon;
use DB;
use Illuminate\Http\Request;
use JavaScript;

class ParetoController extends Controller
{
    use DateTime;
    private $pareto;

    public function __construct(ParetoRepository $pareto)
    {
        $this->middleware('admin');
        $this->pareto = $pareto;
    }

    public function pareto(Request $request)
    {
        $this->jsVariables($request);

        $collections = [
            'table' => $this->pareto->selectCategory($request),
            'SelectedYear' => $request->year ? $request->year : $this->year(),
            'FailureModes' => Info::select('failure_mode')->groupBy('failure_mode')->get(),
            'DiscrepancyCategories' => Info::select('discrepancy_category')->groupBy('discrepancy_category')->get()
        ];

        return view('home.pareto', $collections);
    }

    public function paretoAjax(Request $request)
    {

        $collections = [
            'column' => $request->column,
            'tbl' => $this->filterInfo($request),
            'sort' => $request->sort
        ];

        return view('home.pareto-ajax', $collections);

    }

    private function jsVariables($request)
    {
        $collections = [
            'discrepancy', $request->discrepancy,
            'category', $request->category
        ];

        JavaScript::put($collections);
    }

    private function filterInfo($request)
    {
        return '' != $request->text
            ? $this->filterWithText($request)
            : $this->filterWithoutText($request);
    }

    private function filterWithText($request)
    {
        return Info::orderBy($request->column, $request->sort)
            ->where(DB::raw('YEAR(created_at)'), 'LIKE', "%" . $request->year . "%")
            ->search($request->text)
            ->show($request->start, $request->end)
            ->get();
    }

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
