<?php

namespace App\repo;

use App\Models\Closure;
use App\Models\Info;
use Carbon;
use DB;

class HomeRepository {

    /**
     * @return mixed
     */
    public function dateTime()
	{
		return Carbon::now('Asia/Manila');
	}

    /**
     * @param $request
     * @return array
     */
    public function highChartData($request)
    {
        $pod = $this->paretoOfDiscrepancy($request->month, $request->year);
        $failureMode = $this->paretoOfDiscrepancy($request->month, $request->year, 'failureMode');
        $assembly = $this->paretoOfDiscrepancy($request->month, $request->year, 'assembly');
        $environment = $this->paretoOfDiscrepancy($request->month, $request->year, 'environment');
        $machine = $this->paretoOfDiscrepancy($request->month, $request->year, 'machine');
        $man = $this->paretoOfDiscrepancy($request->month, $request->year, 'man');
        $material = $this->paretoOfDiscrepancy($request->month, $request->year, 'material');
        $process = $this->paretoOfDiscrepancy($request->month, $request->year, 'method / process');
        $arr = ['qdn' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]];

        $info = Info::qdn($request->year)->get();

        foreach ($info as $elem) {
            $arr['qdn'][$elem->month - 1] = round($elem->count / 4);
        }

        $arr['pod'] = $this->collection($pod);
        $arr['failureMode'] = $this->collection($failureMode);
        $arr['assembly'] = $this->collection($assembly);
        $arr['environment'] = $this->collection($environment);
        $arr['machine'] = $this->collection($machine);
        $arr['man'] = $this->collection($man);
        $arr['material'] = $this->collection($material);
        $arr['process'] = $this->collection($process);

        return $arr;
	}

    /**
     * @return array
     */
    public function counter()
    {
        $date = $this->dateTime();
        $closure = Closure::all();
        $collection = [
            'today' => Info::whereDate('created_at', '=', $date->format('Y-m-d'))->count(),
            'week' => Info::where(DB::raw('WEEK(created_at)'), $date->weekOfYear)->count(),
            'month' => Info::whereMonth('created_at', '=', $date->month)->count(),
            'year' => Info::whereYear('created_at', '=', $date->year)->count(),

            'PeVerification' => $this->statusCount($closure, 'P.e. Verification'),
            'Incomplete' => $this->statusCount($closure, 'Incomplete Fill-Up'),
            'Approval' => $this->statusCount($closure, 'Incomplete Approval'),
            'QaVerification' => $this->statusCount($closure, 'Q.a. Verification'),
        ];

		return $collection;
	}

    /**
     * @param $collection
     * @return array
     */
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
     * @param $closure
     * @param $status
     * @return mixed
     */
    private function statusCount($closure, $status)
    {
        return $closure->where('status', $status)->count();
    }

    /**
     * @param $month
     * @param $year
     * @param $pod
     * @return mixed
     */
    private function paretoOfDiscrepancy($month, $year, $pod = '')
    {
        return Info::pod($month, $year, $pod);
    }

}