<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\Info;
use App\Models\Closure;
use Carbon;
use DB;
class HomeComposer {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

    $view->with('charts',[
        [
            'heading' => 'QDN METRICS <br> &nbsp;', 
            'id'      => 'modalQdnMetrics',
            'title'   => '',
            'graph'   => 'qdnMetricsGraph'
        ],
        [
            'heading' => 'PARETO OF DISCREPANCY <br> &nbsp;', 
            'id'      => 'pod',
            'title'   => '',
            'graph'   => 'podGraph'
        ],
        [
            'heading' => 'PARETO OF DISCREPANCY <br> ( FAILURE MODE )', 
            'id'      => 'failureModeModal',
            'title'   => 'Pareto of Discrepancy -  FAILURE MODE ',
            'graph'   => 'failureModeGraph'
        ],
        [
            'heading' => 'PARETO OF DISCREPANCY <br> ( ASSEMBLY )', 
            'id'      => 'assemblyModal',
            'title'   => 'Pareto of Discrepancy -  ASSEMBLY ',
            'graph'   => 'assemblyGraph'
        ],
        [
            'heading' => 'PARETO OF DISCREPANCY <br> ( ENVIRONMENT )', 
            'id'      => 'environmentModal',
            'title'   => 'Pareto of Discrepancy -  ENVIRONMENT ',
            'graph'   => 'environmentGraph'
        ],
        [
            'heading' => 'PARETO OF DISCREPANCY <br> ( MACHINE )', 
            'id'      => 'machineModal',
            'title'   => 'Pareto of Discrepancy -  MACHINE ',
            'graph'   => 'machineGraph'
        ],
        [
            'heading' => 'PARETO OF DISCREPANCY <br> ( MAN )', 
            'id'      => 'manModal',
            'title'   => 'Pareto of Discrepancy -  MAN ',
            'graph'   => 'manGraph'
        ],
        [
            'heading' => 'PARETO OF DISCREPANCY <br> ( MATERIAL )', 
            'id'      => 'materialModal',
            'title'   => 'Pareto of Discrepancy -  MATERIAL ',
            'graph'   => 'materialGraph'
        ],
        [
            'heading' => 'PARETO OF DISCREPANCY <br> ( METHOD / PROCESS )', 
            'id'      => 'processModal',
            'title'   => 'Pareto of Discrepancy - METHOD / PROCESS ',
            'graph'   => 'processGraph'
        ]
    ]);

    $dt = Carbon::now('Asia/Manila');

    $today = Info::where(
            DB::raw('DATE_FORMAT(created_at, "%m-%d-%Y")'),
            "=",
            $dt->format('m-d-Y')
        )->count();

    $month = Info::where(
            DB::raw('MONTH(created_at)'),
            "=",
            $dt->month
        )
        ->where(
                DB::raw('YEAR(created_at)'),
                "=",
                $dt->year
            )->count();

    $week = Info::where(
            DB::raw('WEEK(created_at)'),
            "=",
            $dt->weekOfYear
        )->count();

    $year = Info::where(
            DB::raw('YEAR(created_at)'),
            "=",
            $dt->year
        )->count();

$view->with('counts',[
    [$today, 'today', 'Issued today :'],
    [$week, 'week', 'Issued this week :'],
    [$month, 'month', 'Issued this month :'],
    [$year, 'year', 'Issued this year :']
    ]);



    $peVerification = Closure::where('status', 'p.e. verification')
    ->count();

    $incomplete = Closure::where('status', 'incomplete fill-up')
    ->count();

    $approval = Closure::where('status', 'incomplete approval')
    ->count();

    $qaVerification = Closure::where('status', 'q.a. verification')
    ->count();


$view->with('status',[
    [$peVerification, 'peVerification', 'P.E. Verification :'],
    [$incomplete, 'incomplete', 'Incomplete fill-up:'],
    [$approval, 'approval', 'Incomplete approval :'],
    [$qaVerification, 'qaVerification', 'Q.A. Verification :']
    ]);
    }

}