<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\Info;
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
        ['QDN METRICS <br> &nbsp;', 'modalQdnMetrics'],
        ['PARETO OF DISCREPANCY <br> &nbsp;', 'pod'],
        ['PARETO OF DISCREPANCY <br> ( ASSEMBLY )', 'pod_assembly'],
        ['PARETO OF DISCREPANCY <br> ( ENVIRONMENT )', 'pod_environment'],
        ['PARETO OF DISCREPANCY <br> ( FAILURE MODE )', 'pod_failure_mode'],
        ['PARETO OF DISCREPANCY <br> ( MACHINE )', 'pod_machine'],
        ['PARETO OF DISCREPANCY <br> ( MAN )', 'pod_man'],
        ['PARETO OF DISCREPANCY <br> ( MATERIAL )', 'pod_material'],
        ['PARETO OF DISCREPANCY <br> ( METHOD )', 'pod_method']
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
    }

}