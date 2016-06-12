<?php

namespace App\repo;

use App\Models\Closure;
use App\Models\Info;
use App\repo\Traits\DateTime;
use Carbon;
use DB;

class HomeRepository {

    use DateTime;

    public function highChartData($request)
    {
        return collect(['all', 'failureMode', 'assembly', 'environment', 'machine', 'man', 'material', 'process'])
            ->flatMap(function($type) use ($request) {
                return [$type == 'all' ? 'pod' : $type => $this->collection(Info::pod($request->month, $request->year, $type))];
            })->merge(['qdn' => $this->byAnnual()]);
	}

    public function counter()
    {
        $collections = collect([

            'PeVerification' => 'P.e. Verification',
            'Incomplete' => 'Incomplete Fill-Up',
            'Approval' => 'Incomplete Approval',
            'QaVerification' => 'Q.a. Verification'

        ])->map(function($status) {
            return Closure::statusCount($status);
        })->merge([
            'today' => Info::todayCount(),
            'week' => Info::weekCount(),
            'month' => Info::monthCount(),
            'year' => Info::yearCount()
        ]);

        return $collections;
	}

    public function collection($collection) {
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

        $arr['total'] = isset($arr['bars']) ? array_sum($arr['bars']) : 0;
        return $arr;
    }

    /**
     * @return static
     */
    protected function byAnnual()
    {
        $annualQdn = collect(Info::fromYear($this->year()))->reduce(function ($carry, $index) {
            return $carry + [$index->month - 1 => round($index->count / 4)];
        }, []);

        return collect([0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0])->map(function ($value, $index) use ($annualQdn) {
            return collect($annualQdn)->get($index, 0);
        }, []);
    }

}