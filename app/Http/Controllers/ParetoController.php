<?php namespace App\Http\Controllers;

use App\Models\Info;
use App\repo\ParetoRepository;
use App\repo\Traits\DateTime;
use Carbon;
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
            'FailureModes' => Info::failureModeCategory(),
            'DiscrepancyCategories' => Info::discrepancyCategory()
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
            ? Info::filterWithText($request)
            : Info::filterWithOutText($request);
    }
}
