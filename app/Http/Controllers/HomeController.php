<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\Models\Info;
use DB;
use Carbon;
use JavaScript;

class HomeController extends Controller
{

    public $dt;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dt = Carbon::now('Asia/Manila');
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        if (Auth::user()) {
            $qdn = Info::all();
            JavaScript::put('datus', [0,0,0,0,0,0,0,0,0,0,0,0]);
            JavaScript::put('yearNow', Carbon::now('Asia/Manila')->year);
            $info = Info::select(DB::raw('COUNT(discrepancy_category) as paretoFirst'))
            ->groupBy('discrepancy_category')
            ->where(
                DB::raw('MONTH(created_at)'),
                $this->dt->month
            )
            ->where(
                    DB::raw('YEAR(created_at)'),
                    $this->dt->year
                )->get('paretoFirst');
            $tbl = array_flatten($info->toArray());
            $count = $info->count();
            $legends = [];
            $legend = 'A';

            foreach ($info as $val) {

                $legends[] = $legend++;
            }

            JavaScript::put('legends', $legends);
            JavaScript::put('paretoFirst', $tbl);
            JavaScript::put('paretoCount', $count);
            return view('home');
        }
        return view('welcome');

    }

    /**
     * ajax call for highchart live update
     * @return [type] [description]
     */
    public function ajax()
    {
        $year = Carbon::now('Asia/Manila')->year;
        $info = Info::select(
                DB::raw('
                    MONTH(created_at) as month,
                    COUNT(MONTH(created_at)) as count
                ')
            )
            ->where(DB::raw('YEAR(created_at)'), $year)
            ->groupBy('month')
            ->get();
            $arr = ['qdn' => [0,0,0,0,0,0,0,0,0,0,0,0]];
            foreach ($info as $elem) {
            $arr['qdn'][$elem->month -1] = round($elem->count/4);
            }
            return $arr;
    }

    /**
     * ajax call for qdn issuance updates
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function qdnData(Request $request)
    {
switch ($request->input('setDate')) {
    case 'today':
    $tbl = Info::where(
            DB::raw('DATE_FORMAT(created_at, "%m-%d-%Y")'),
            "=",
            $this->dt->format('m-d-Y')
        )->get();
        break;
    case 'week':
        $tbl = Info::where(
            DB::raw('WEEK(created_at)'),
            "=",
            $this->dt->weekOfYear
        )->get();
        break;
    case 'month':
        $tbl = Info::where(
            DB::raw('MONTH(created_at)'),
            "=",
            $this->dt->month
        )
        ->where(
                DB::raw('YEAR(created_at)'),
                "=",
                $this->dt->year
            )->get();


        # code...
        break;
    case 'year':
        $tbl = Info::where(
            DB::raw('YEAR(created_at)'),
            "=",
            $this->dt->year
        )->get();
        # code...
        break;

    default:
        $tbl = Info::all();
        break;
}
        return view('home.qdnData',compact('tbl'));
    }
}
