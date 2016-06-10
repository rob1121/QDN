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
        collect(['all', 'failureMode', 'assembly', 'environment', 'machine', 'man', 'material', 'process'])
            ->flatMap(function($type) use ($request){
            return [$type => $this->collection(Info::pod($request->month, $request->year, $type))];
        })->merge(['qdn' => $arr]);

        collect(Info::qdn($request->year)->get())->map(function($elem) {
            return [$elem->month - 1 => round($elem->count / 4)];
        })
            ->merge([0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0])
            ->take(12);
	}

    public function counter()
    {
        $closure = Closure::all();

        $collections = collect([
            
            'PeVerification' => 'P.e. Verification',
            'Incomplete' => 'Incomplete Fill-Up',
            'Approval' => 'Incomplete Approval',
            'QaVerification' => 'Q.a. Verification'
            
        ])->map(function($item) use ($closure) {
            return $item;
        })->merge([
            'today' => Info::whereDate('created_at', '=', $this->date()->format('Y-m-d'))->count(),
            'week' => Info::where(DB::raw('WEEK(created_at)'), $this->date()->weekOfYear)->count(),
            'month' => Info::whereMonth('created_at', '=', $this->date()->month)->count(),
            'year' => Info::whereYear('created_at', '=', $this->date()->year)->count()
        ]);
        $annualQdn = collect(Info::fromYear(2016))->map(function ($index) {
            return ['key' => $index->month - 1, 'value' => round($index->count / 4)];
        });
return collect([0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0])->map(function($value, $index) {
    if($index > 5) return $value;
});
        return $data;

        return collect(Info::fromYear(2016))
            ->map(function($index) {
                return [$index->month - 1 => round($index->count / 4)];
            })
            ->merge([0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0])
            ->take(12);

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