<?php namespace App\repo;

use App\Models\Info;
use App\repo\Traits\DateTime;

class ParetoRepository
{
    use DateTime;

    public function selectCategory($request)
    {
       return collect([
            'total' => Info::total($request->month, $this->year()),
            'failureMode' => Info::failureMode($request, $request->month, $this->year()),
            'fmTotal' =>  Info::failureMode($request, $request->month, $this->year()),
            'pod' => Info::paretoOfDiscrepancy($request, $this->year()),
            'today' => Info::today(),
            'week' => Info::week(),
            'month' => Info::month(),
            'year' => Info::year()
        ])->get(
            $request->category,
           Info::defaultCategory($request)
        );
    }
}