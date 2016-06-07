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
        $pod = $this->paretoOfDiscrepancy($request->month, $request->year);
        $failureMode = $this->paretoOfDiscrepancy($request->month, $request->year, 'failureMode');
        $assembly = $this->paretoOfDiscrepancy($request->month, $request->year, 'assembly');
        $environment = $this->paretoOfDiscrepancy($request->month, $request->year, 'environment');
        $machine = $this->paretoOfDiscrepancy($request->month, $request->year, 'machine');
        $man = $this->paretoOfDiscrepancy($request->month, $request->year, 'man');
        $material = $this->paretoOfDiscrepancy($request->month, $request->year, 'material');
        $process = $this->paretoOfDiscrepancy($request->month, $request->year, 'method / process');

        $arr = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach (Info::qdn($request->year)->get() as $elem)
            $arr[$elem->month - 1] = round($elem->count / 4);

        return [
            'qdn' => $arr,
            'pod' => $this->collection($pod),
            'failureMode' => $this->collection($failureMode),
            'assembly' => $this->collection($assembly),
            'environment' => $this->collection($environment),
            'machine' => $this->collection($machine),
            'man' => $this->collection($man),
            'material' => $this->collection($material),
            'process' => $this->collection($process)
        ];
	}

    public function counter()
    {
        $closure = Closure::all();

        $collections = collect([
            
            'PeVerification' => 'P.e. Verification',
            'Incomplete' => 'Incomplete Fill-Up',
            'Approval' => 'Incomplete Approval',
            'QaVerification' => 'Q.a. Verification'
            
        ])->map(function($item, $key) use ($closure) {
            
            return [$key => $this->statusCount($closure, $item)];
            
        })->merge([
            
            'today' => Info::whereDate('created_at', '=', $this->date()->format('Y-m-d'))->count(),
            'week' => Info::where(DB::raw('WEEK(created_at)'), $this->date()->weekOfYear)->count(),
            'month' => Info::whereMonth('created_at', '=', $this->date()->month)->count(),
            'year' => Info::whereYear('created_at', '=', $this->date()->year)->count()
            
        ])->flatten();

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

    private function statusCount($closure, $status)
    {
        return $closure->where('status', $status)->count();
    }

    private function paretoOfDiscrepancy($month, $year, $pod = '')
    {
        return Info::pod($month, $year, $pod);
    }

}