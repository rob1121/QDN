<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Ajax\ajaxController;
use Auth;

use App\Models\Info;
use DB;
use Carbon;
use JavaScript;

class HomeController extends ajaxController
{

    public $dateTime;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dateTime = Carbon::now('Asia/Manila');
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

            $qdn  = Info::all();
            $info = Info::pod( $this->dateTime->month, $this->dateTime->year )
                ->get();

            $legend = 'A';
            $lines = [];
            foreach ($info as $value) {
               $pod['legends'][]       = $legend++;
               $pod['bars'][]          = $value->paretoFirst;
               $pod['discrepancies'][] = $value->discrepancy_category;
               $pod['lines'][]         = array_sum($lines) + $value
                    ->paretoFirst;
            }
            //counts per pareto of discrepancy
            $total = array_sum($bars); //grand total

            $count = $info->count();

            JavaScript::put('datus', [0,0,0,0,0,0,0,0,0,0,0,0]);
            JavaScript::put('yearNow', $this->dateTime->year);
            JavaScript::put('legends', $pod['legends']); //title
            JavaScript::put('bars', $pod['bars']); //data
            JavaScript::put('total', $pod['total']); //total
            JavaScript::put('lines', $pod['lines']); // title 2nd
            return view('home',
                compact(
                    'pod',
                    'total'
                ));
        }
        return view('welcome');

    }

    /**
     * ajax call for highchart live update
     * @return [type] [description]
     */
    public function ajax()
    {
        $info = Info::qdn($this->dateTime->year)->get();
        $pod  = Info::pod( $this->dateTime->month, $this->dateTime->year)
            ->get();

        $arr = ['qdn' => [0,0,0,0,0,0,0,0,0,0,0,0]];

        foreach ($info as $elem) {
            $arr['qdn'][$elem->month -1] = round($elem->count/4);
        }
        foreach ($pod as $elem) {
            $arr['pod']['count'][]    = $elem->paretoFirst;
            $arr['pod']['category'][] = $elem->discrepancy_category;
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
                    $this->dateTime->format('m-d-Y')
                )->get();
                break;
            case 'week':
                $tbl = Info::where(
                    DB::raw('WEEK(created_at)'),
                    "=",
                    $this->dateTime->weekOfYear
                )->get();
                break;
            case 'month':
                $tbl = Info::where(
                    DB::raw('MONTH(created_at)'),
                    "=",
                    $this->dateTime->month
                )
                ->where(
                        DB::raw('YEAR(created_at)'),
                        "=",
                        $this->dateTime->year
                    )->get();


                # code...
                break;
            case 'year':
                $tbl = Info::where(
                    DB::raw('YEAR(created_at)'),
                    "=",
                    $this->dateTime->year
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
