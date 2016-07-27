<?php namespace App\repo\API;

use App\Models\Closure;
use App\Models\Info;
use Illuminate\Support\Facades\DB;
use App\repo\Traits\DateTime;
class Api {

    use DateTime;

    public function cycleTime()
    {
        return Info::where(DB::raw('MONTH(created_at)'), 7)->with('closure')->get()
            ->map(function($key) { return $this->getIssuedTimeAndClosedTime($key); })
            ->map(function($key) { return $this->getCycleTimeByHour($key); });
    }

    protected function getIssuedTimeAndClosedTime($key)
    {
        return ['created' => strtotime($key->created_at), 'closed' => strtotime($key->closure->date_sign)];
    }

    protected function getCycleTimeByHour($key)
    {
        return round(($key['closed'] - $key['created']) / 60 / 60);
    }
    
    public function cycleTimeAverage()
    {
        return $this->cycleTime()->flatten()->avg();
    }

    public function cycleTimePareto()
    {
        $perMonth = collect([1,2,3,4,5,6,7,8,9,10,11,12])
            ->map(function($month) { return $this->CycleTimeAveragePerMonth($month); });

        return $this->getCollectionOfCycleTimeForEachMonth($perMonth);
    }

    public function CycleTimeAveragePerMonth($month)
    {
        return $this->getColumnMonthCreatedTimeAndClosingTime($month)
            ->map(function ($key) { return $this->getCycleTimeByHour($key); })->avg();
    }

    protected function getColumnMonthCreatedTimeAndClosingTime($month)
    {
        return Closure::CycleTimeForMonth($month)
            ->map(function ($key) {
                return [ 'month' => $key->month, 'created' => strtotime($key->created_at), 'closed' => strtotime($key->date_sign)];
            });
    }
    
    public function stationPie()
    {
        return Info::getCountPerStation()->map(function($key) {
            return $this->getArrayOfDataPerStationForPieChart($key, $this);
            });
    }

    protected function getArrayOfDataPerStationForPieChart($key, $this)
    {
        return [
            'name' => $key->station,
            'y' => $key->count,
            'sliced' => $this->isTopContributor($key->station),
            'selected' => $this->isTopContributor($key->station)
        ];
    }

    protected function isTopContributor($station)
    {
        return Info::getTopContributorByStation() == $station;
    }

    protected function getCollectionOfCycleTimeForEachMonth($perMonth)
    {
        return collect([0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0])
            ->map(function ($value, $index) use ($perMonth) {
                return collect($perMonth)->get($index, 0);
            });
    }
}