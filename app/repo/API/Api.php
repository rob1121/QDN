<?php namespace App\repo\API;

use App\Models\Closure;
use App\Models\Info;
use Illuminate\Support\Facades\DB;
use App\repo\Traits\DateTime;
class Api {

    use DateTime;

    public function cycleTime()
    {
        return Info::where(DB::raw('MONTH(created_at)'), 7)->with('closure')->get()->map(function($key)
        {
            return [
                'created' => strtotime($key->created_at),
                'closed' => strtotime($key->closure->date_sign)
            ];
        })->map(function($key)
        {
            $diff = round(($key['closed'] - $key['created']) / 60 / 60);

            return $diff;
        });
    }
    
    public function cycleTimeAverage()
    {
        return $this->cycleTime()
            ->flatten()
            ->avg();
    }

    public function cycleTimePareto()
    {
        $perMonth = collect([1,2,3,4,5,6,7,8,9,10,11,12])->map(function($month)
        {
            return $this->CycleTimeAveragePerMonth($month);
        });

        return collect([0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0])->map(function ($value, $index) use ($perMonth) {
            return collect($perMonth)->get($index, 0);
        });
    }

    public function CycleTimeAveragePerMonth($month)
    {
        return Closure::select(DB::raw("MONTH(created_at) as month"), 'created_at', 'date_sign')
            ->where(DB::raw('MONTH(created_at)'), $month)
            ->whereStatus('closed')
            ->get()
            ->map(function ($key) {
                return toObject([
                    'month' => $key->month,
                    'created' => strtotime($key->created_at),
                    'closed' => strtotime($key->date_sign)
                ]);
            })->map(function ($key) {
                $diff = round(($key->closed - $key->created) / 60 / 60);

                return [
                    'month' => $key->month,
                    'duration' => $diff
                ];
            })->map(function ($value) {
                return $value['duration'];
            })->avg();
    }
}