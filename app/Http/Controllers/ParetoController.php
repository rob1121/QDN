<?php namespace App\Http\Controllers;

use App\Models\Info;
use App\repo\ParetoRepository;
use App\repo\Traits\DateTime;
use App\User;
use Carbon;
use Illuminate\Http\Request;
use JavaScript;
use Maatwebsite\Excel\Facades\Excel;

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

    public function excel()
    {
        $qdn = Info::all();

        Excel::create('users', function($excel) use($qdn) {
            $excel->sheet('Sheet 1', function($sheet) use($qdn) {
                $sheet->fromArray($qdn);
            });
        })->download('csv');
    }

    private function filterInfo($request)
    {
        return '' != $request->text
            ? Info::filterWithText($request)
            : Info::filterWithOutText($request);
    }
}
