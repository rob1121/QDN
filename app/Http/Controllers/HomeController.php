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
            JavaScript::put('yearNow', $this->dateTime->year);
            return view('home');
        }
        return view('welcome');

    }


    /**
     * array function for getting data for graphs
     */
    protected function arrayCollection($collection)
        {
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
            $arr['total'] = 0;

            if (isset($arr['bars'])) {
            $arr['total'] = array_sum($arr['bars']);
            }

            return $arr;
        }

    /**
     * ajax call for highchart live update
     * @return [type] [description]
     */
    public function ajax()
    {
        //date
        $month    = $this->dateTime->month;
        $year     = $this->dateTime->year;

        //retrieve data collection
        $info        = Info::qdn($year)->get();
        $pod         = Info::pod( $month, $year);
        $failureMode = Info::pod( $month, $year, 'failureMode');
        $assembly    = Info::pod( $month, $year, 'assembly');
        $environment = Info::pod( $month, $year, 'environment');
        $machine     = Info::pod( $month, $year, 'machine');
        $man         = Info::pod( $month, $year, 'man');
        $material    = Info::pod( $month, $year, 'material');
        $process     = Info::pod( $month, $year, 'method / process');

        $arr = ['qdn' => [0,0,0,0,0,0,0,0,0,0,0,0]];

        foreach ($info as $elem) {
            $arr['qdn'][$elem->month -1] = round($elem->count/4);
        }

        $arr['pod']         = $this->arrayCollection($pod);
        $arr['failureMode'] = $this->arrayCollection($failureMode);
        $arr['assembly']    = $this->arrayCollection($assembly);
        $arr['environment'] = $this->arrayCollection($environment);
        $arr['machine']     = $this->arrayCollection($machine);
        $arr['man']         = $this->arrayCollection($man);
        $arr['material']    = $this->arrayCollection($material);
        $arr['process']     = $this->arrayCollection($process);

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
                break;
            case 'year':
                $tbl = Info::where(
                    DB::raw('YEAR(created_at)'),
                    "=",
                    $this->dateTime->year
                )->get();
                break;

            default:
                $tbl = Info::all();
                break;
        }
        return view('home.qdnData',compact('tbl'));
    }


}
