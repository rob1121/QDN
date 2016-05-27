<?php
/**
 * Created by PhpStorm.
 * User: tspi.qa
 * Date: 5/27/2016
 * Time: 11:09 AM
 */

namespace app\repo;


use App\Models\Info;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ParetoRepository
{
    private $dateTime;

    public function __construct()
    {
        $this->dateTime = Carbon::now('Asia/Manila');;
    }
    /**
     * @param $request
     * @return mixed
     */
    public function selectCategory($request)
    {
        $month = Carbon::parse($request->month)->format('m');
        if ('total' == $request->category)
            $table = $this->totalCategory($month);

        elseif ('failureMode' == $request->category || 'fmTotal' == $request->category)
            $table = $this->failureModeCategory($request, $month);

        elseif (('pod' == $request->category))
            $table = $this->paretoOfDiscrepancyCategory($request);

        elseif ('today' == $request->category)
            $table = $this->todayCategory();

        elseif ('week' == $request->category)
            $table = $this->weekCategory();

        elseif ('month' == $request->category)
            $table = $this->monthCategory();

        elseif ('year' == $request->category)
            $table = $this->yearCategory();

        else $table = Info::with(['involvePerson'])->where(DB::raw('YEAR(created_at)'), $this->year)
            ->where(DB::raw('MONTH(created_at)'), $month)
            ->where('discrepancy_category', $request->discrepancy)
            ->show(0, 10)
            ->get();

        return $table;
    }

    /**
     * @param $month
     * @return mixed
     */
    private function totalCategory($month)
    {
        $table = Info::with(['involvePerson'])->where(DB::raw('YEAR(created_at)'), $this->year)
            ->where(DB::raw('MONTH(created_at)'), $month)
            ->show(0, 10)
            ->get();
        return $table;
    }

    /**
     * @param $request
     * @param $month
     * @return mixed
     */
    private function failureModeCategory($request, $month)
    {
        $table = Info::with(['involvePerson'])->where(DB::raw('YEAR(created_at)'), $this->year)
            ->where(DB::raw('MONTH(created_at)'), $month)
            ->where('failure_mode', $request->discrepancy)
            ->show(0, 10)
            ->get();
        return $table;
    }

    /**
     * @param $request
     * @return mixed
     */
    private function paretoOfDiscrepancyCategory($request)
    {
        $table = Info::with(['involvePerson'])->where(DB::raw('YEAR(created_at)'), $this->year)
            ->where('discrepancy_category', $request->discrepancy)
            ->show(0, 10)
            ->get();
        return $table;
    }

    /**
     * @return mixed
     */
    private function todayCategory()
    {
        $table = Info::with(['involvePerson'])->where(
            DB::raw('DATE_FORMAT(created_at, "%m-%d-%Y")'),
            "=",
            $this->dateTime->format('m-d-Y')
        )
            ->show(0, 10)
            ->get();
        return $table;
    }

    /**
     * @return mixed
     */
    private function weekCategory()
    {
        $table = Info::with(['involvePerson'])->where(
            DB::raw('WEEK(created_at)'),
            "=",
            $this->dateTime->weekOfYear
        )
            ->show(0, 10)
            ->get();
        return $table;
    }

    /**
     * @return mixed
     */
    private function monthCategory()
    {
        $table = Info::with(['involvePerson'])->where(
            DB::raw('MONTH(created_at)'),
            "=",
            $this->dateTime->month
        )
            ->where(
                DB::raw('YEAR(created_at)'),
                "=",
                $this->dateTime->year
            )
            ->show(0, 10)
            ->get();
        return $table;
    }

    /**
     * @return mixed
     */
    private function yearCategory()
    {
        $table = Info::with(['involvePerson'])->where(
            DB::raw('YEAR(created_at)'),
            "=",
            $this->dateTime->year
        )
            ->show(0, 10)
            ->get();
        return $table;
    }
}