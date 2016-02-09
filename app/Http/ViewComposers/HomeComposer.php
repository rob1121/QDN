<?php
namespace App\Http\ViewComposers;

use App\Models\Closure;
use App\Models\Info;
use Carbon;
use DB;
use Illuminate\Contracts\View\View;

class HomeComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $view->with('charts', [
            [
                'heading' => 'QDN METRICS <br> &nbsp;',
                'id'      => 'modalQdnMetrics',
                'title'   => '',
                'graph'   => 'qdnMetricsGraph',
                'table'   => 'qdnMetricsTable',
            ],
            [
                'heading' => 'PARETO OF DISCREPANCY <br> &nbsp;',
                'id'      => 'pod',
                'title'   => '',
                'graph'   => 'podGraph',
                'table'   => 'podTable',
            ],
            [
                'heading' => 'PARETO OF DISCREPANCY <br> ( FAILURE MODE )',
                'id'      => 'failureModeModal',
                'title'   => 'Pareto of Discrepancy -  FAILURE MODE ',
                'graph'   => 'failureModeGraph',
                'table'   => 'failureModeTable',
            ],
            [
                'heading' => 'PARETO OF DISCREPANCY <br> ( ASSEMBLY )',
                'id'      => 'assemblyModal',
                'title'   => 'Pareto of Discrepancy -  ASSEMBLY ',
                'graph'   => 'assemblyGraph',
                'table'   => 'assemblyTable',
            ],
            [
                'heading' => 'PARETO OF DISCREPANCY <br> ( ENVIRONMENT )',
                'id'      => 'environmentModal',
                'title'   => 'Pareto of Discrepancy -  ENVIRONMENT ',
                'graph'   => 'environmentGraph',
                'table'   => 'environmentTable',
            ],
            [
                'heading' => 'PARETO OF DISCREPANCY <br> ( MACHINE )',
                'id'      => 'machineModal',
                'title'   => 'Pareto of Discrepancy -  MACHINE ',
                'graph'   => 'machineGraph',
                'table'   => 'machineTable',
            ],
            [
                'heading' => 'PARETO OF DISCREPANCY <br> ( MAN )',
                'id'      => 'manModal',
                'title'   => 'Pareto of Discrepancy -  MAN ',
                'graph'   => 'manGraph',
                'table'   => 'manTable',
            ],
            [
                'heading' => 'PARETO OF DISCREPANCY <br> ( MATERIAL )',
                'id'      => 'materialModal',
                'title'   => 'Pareto of Discrepancy -  MATERIAL ',
                'graph'   => 'materialGraph',
                'table'   => 'materialTable',
            ],
            [
                'heading' => 'PARETO OF DISCREPANCY <br> ( METHOD / PROCESS )',
                'id'      => 'processModal',
                'title'   => 'Pareto of Discrepancy - METHOD / PROCESS ',
                'graph'   => 'processGraph',
                'table'   => 'processTable',
            ],
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

        $view->with('counts', [
            [$today, 'today-col', 'Issued today :', 'today', 'text-today'],
            [$week, 'week-col', 'Issued this week :', 'week', 'text-week'],
            [$month, 'month-col', 'Issued this month :', 'month', 'text-month'],
            [$year, 'year-col', 'Issued this year :', 'year', 'text-year'],
        ]);

        $peVerification = Closure::where('status', 'p.e. verification')
            ->count();

        $incomplete = Closure::where('status', 'incomplete fill-up')
            ->count();

        $approval = Closure::where('status', 'incomplete approval')
            ->count();

        $qaVerification = Closure::where('status', 'q.a. verification')
            ->count();

        $view->with('status', [
            [$peVerification, 'peVerification', 'P.E. Verification :', 'text-peVerification'],
            [$incomplete, 'incomplete', 'Incomplete fill-up:', 'text-incomplete'],
            [$approval, 'approval', 'Incomplete approval :', 'text-approval'],
            [$qaVerification, 'qaVerification', 'Q.A. Verification :', 'text-qaVerification'],
        ]);
        $yearOption = Info::select(DB::raw('YEAR(created_at) as year'))
            ->groupBy('year')
            ->get()
            ->toArray();
        $view->with('months', ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december']);
        $view->with('years', array_flatten($yearOption));
    }

}
