<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Str;

class Info extends Model implements SluggableInterface {
    public $dateTime;
	use SluggableTrait;

	protected $sluggable = [
		'build_from' => 'problem_description',
		'save_to'    => 'slug',
	];

	protected $fillable = [
		'control_id',
		'customer',
		'package_type',
		'device_name',
		'lot_id_number',
		'lot_quantity',
		'job_order_number',
		'machine',
		'station',
		'date',
		'year',
		'month',
		'major',
		'disposition',
		'problem_description',
		'failure_mode',
		'discrepancy_category',
		'quantity',
	];

    const rules = [
        'package_type' => 'required',
        'device_name' => 'required',
        'lot_id_number' => 'required',
        'lot_quantity' => 'required | numeric',
//        'job_order_number' => 'required',
        'machine' => 'required',
        'station' => 'required',
        'receiver_name' => 'required',
        'major' => 'required',
        'failure_mode' => 'required',
        'discrepancy_category' => 'required',
        'problem_description' => 'required|min:6|max:120',
    ];

    public static function date()
    {
        return Carbon::now('Asia/Manila');
    }

	public static function todayCount()
	{
		return Info::whereDate('created_at', '=', static::date()->format('Y-m-d'))->count();
	}

    public static function weekCount()
    {
        return Info::where(DB::raw('WEEK(created_at)'), static::date()->weekOfYear)->count();
    }

    public static function monthCount()
    {
        Info::whereMonth('created_at', '=', static::date()->month)->count();
    }

    public static function yearCount()
    {
        return Info::whereYear('created_at', '=', static::date()->year)->count();
    }

    public static function recentPost()
    {
        $info = Info::orderBy('created_at', 'desc')->take(5)->get()->load('closure');
		$info->map(function($qdn)
        {
			if( ! $qdn->closure()->count())
			{
				throw new Exception('closure relation to parent info not found');
			}
		});

        return $info;
    }

	public static function getCountPerStation()
	{
		return Info::select(DB::raw("COUNT(station) as count"), 'station')
			->groupBy('station')->get();
	}

	public static function getTopContributorByStation()
	{
		return Info::getCountPerStation()->sortByDesc('count')->first()->station;
	}

	// DEFINE RELATIONSHIPS --------------------------------------------------
    public function causeOfDefect()
	{
        return $this->hasOne('App\Models\CauseOfDefect');
    }
    public function containmentAction()
	{
        return $this->hasOne('App\Models\ContainmentAction');
    }

    public function correctiveAction()
	{
        return $this->hasOne('App\Models\CorrectiveAction');
    }

    public function preventiveAction()
	{
        return $this->hasOne('App\Models\PreventiveAction');
    }

    public function qdnCycle()
	{
        return $this->hasOne('App\Models\QdnCycle');
    }

    public function closure()
	{
        return $this->hasOne('App\Models\Closure');
    }

    public function involvePerson()
	{
        return $this->hasMany('App\Models\InvolvePerson');
    }

    public function eventLog()
	{
        return $this->hasMany('App\Models\EventLogs');
    }

    public function getRouteKeyName()
	{
        return 'slug';
    }

    public static function discrepancyCategory()
    {
        return Info::select('discrepancy_category')->groupBy('discrepancy_category')->get();
    }

    public static function failureModeCategory()
    {
        return Info::select('failure_mode')->groupBy('failure_mode')->get();
    }

    public static function filterWithText($request)
    {
        return Info::orderBy($request->column, $request->sort)
            ->where(DB::raw('YEAR(created_at)'), 'LIKE', "%" . $request->year . "%")
            ->search($request->text)
            ->show($request->start, $request->end)
            ->get();
    }

    public static function filterWithOutText($request)
    {
        $condition = '' == $request->month ? 'LIKE' : '=';
        $month = '' == $request->month ? '%' . $request->month . '%' : $request->month;

        $option = Info::orderBy($request->column, $request->sort)
            ->where(DB::raw('YEAR(created_at)'), 'LIKE', '%' . $request->year . '%')
            ->where(DB::raw('MONTH(created_at)'), $condition, $month)
            ->where('discrepancy_category', 'LIKE', '%' . $request->discrepancy . '%')
            ->where('failure_mode', 'LIKE', '%' . $request->FailureMode)
            ->show($request->start, $request->end)
            ->get();

        return $option;
    }

    public static function total($year, $month)
    {
        return Info::with('involvePerson')->where(DB::raw('YEAR(created_at)'), $year)
            ->where(DB::raw('MONTH(created_at)'), $month)
            ->show(0, 10)
            ->get();
    }

    public static function failureMode($request, $month, $year)
    {
        return Info::with('involvePerson')->where(DB::raw('YEAR(created_at)'), $year)
            ->where(DB::raw('MONTH(created_at)'), $month)
            ->where('failure_mode', $request->discrepancy)
            ->show(0, 10)
            ->get();
    }

    public static function paretoOfDiscrepancy($request, $year)
    {
        return Info::with('involvePerson')->where(DB::raw('YEAR(created_at)'), $year)
            ->where('discrepancy_category', $request->discrepancy)
            ->show(0, 10)
            ->get();
    }

    public static function today()
    {
        $today = Carbon::now('Asia/Manila')->format('m-d-Y');

        return Info::with('involvePerson')->where(DB::raw('DATE_FORMAT(created_at, "%m-%d-%Y")'), "=", $today)
            ->show(0, 10)
            ->get();
    }

    public static function week()
    {
        $today = Carbon::now('Asia/Manila');

        return Info::with('involvePerson')->where(DB::raw('WEEK(created_at)'), "=", $today->weekOfYear)
            ->show(0, 10)
            ->get();
    }

    public static function month()
    {
        $today = Carbon::now('Asia/Manila');

        return Info::with('involvePerson')->where(DB::raw('MONTH(created_at)'), "=", $today->month)
            ->where(DB::raw('YEAR(created_at)'), "=", $today->year)
            ->show(0, 10)
            ->get();
    }

    public static function year()
    {
        $today = Carbon::now('Asia/Manila');

        return Info::with('involvePerson')->where(DB::raw('YEAR(created_at)'), "=", $today->year)
            ->show(0, 10)
            ->get();
    }

    public static function defaultCategory($request)
    {
        $today = Carbon::now('Asia/Manila');
        return Info::with('involvePerson')->where(DB::raw('YEAR(created_at)'), $today->year)
            ->where(DB::raw('MONTH(created_at)'), $request->month)
            ->where('discrepancy_category', $request->discrepancy)
            ->show(0, 10)
            ->get();
    }

    public static function withClosure($slug)
    {
        return Info::whereSlug($slug)->with('closure')->first();
    }

    public static function issuedFrom($date)
    {
        $today = Carbon::now('Asia/Manila');

        return collect([
            'today' => Info::where( DB::raw('DATE_FORMAT(created_at, "%m-%d-%Y")'), "=", $today->format('m-d-Y'))->get(),
            'week' => Info::where( DB::raw('WEEK(created_at)'), "=", $today->weekOfYear )->get(),
            'month' => Info::where( DB::raw('MONTH(created_at)'), "=", $today->month )->where(DB::raw('YEAR(created_at)'),"=",$today->year)->get(),
            'year' => Info::where(DB::raw('YEAR(created_at)'), "=", $today->year)->get()
        ])->get($date);
    }

    public static function fromYear($year)
    {
        return Info::select(DB::raw('MONTH(created_at) as month, COUNT(MONTH(created_at)) as count'))
            ->where(DB::raw('YEAR(created_at)'), $year)
            ->groupBy('month')->get();
    }

    public static function isExist($request)
	{
        return Info::whereCustomer($request->customer)
            ->wherePackageType($request->package_type)
            ->whereDeviceName($request->device_name)
            ->whereLotIdNumber($request->lot_id_number)
            ->whereLotQuantity($request->lot_quantity)
            ->whereJobOrderNumber($request->job_order_number)
            ->whereMachine($request->machine)
            ->whereStation($request->station)
            ->whereMajor($request->major)
            ->whereProblemDescription($request->problem_description)
            ->whereFailureMode($request->failure_mode)
            ->whereDiscrepancyCategory($request->discrepancy_category)
            ->whereQuantity($request->quantity)->count() > 0;
    }

	/**
	 * retrieving data from table for BMP graphs
	 * @param $query
	 * @param $month
	 * @param $year
	 * @param string $select
	 * @return
	 */
	public function scopePod($query, $month, $year, $select = 'all')
	{

		$select = $select == 'process' ? 'method / process' : $select;

		if ('' == $select || 'all' == $select)
		{
			return $query->select(DB::raw(
				'COUNT(discrepancy_category) as paretoFirst,
                    discrepancy_category as category'
			))
				->groupBy('discrepancy_category')
				->where(DB::raw('MONTH(created_at)'), $month ? '=' : 'LIKE', $month ? $month : '%%')
				->where(DB::raw('YEAR(created_at)'), $year)
				->get();

		}

		if ('failureMode' == $select)
		{

			return $query->select(DB::raw(
				'COUNT(failure_mode) as paretoFirst,
                    failure_mode as category'
			))
				->groupBy('failure_mode')

				->where(DB::raw('MONTH(created_at)'), $month ? '=' : 'LIKE', $month ? $month : '%%')
				->where(DB::raw('YEAR(created_at)'), $year)
				->get();

		}

		return $query->select(DB::raw(
			'COUNT(failure_mode) as paretoFirst,
                failure_mode as category'
		))
			->groupBy('failure_mode')

				->where(DB::raw('MONTH(created_at)'), $month ? '=' : 'LIKE', $month ? $month : '%%')
			->where(DB::raw('YEAR(created_at)'), $year)
			->where('failure_mode', $select)
			->get();

	}

	public function scopeSearch($query, $text)
	{
		$query->where('problem_description', 'LIKE', "%" . $text . "%")
			->orWhere('discrepancy_category', 'LIKE', "%" . $text . "%")
			->orWhere('control_id', 'LIKE', "%" . $text . "%")
			->orWhere('customer', 'LIKE', "%" . $text . "%")
			->orWhere('station', 'LIKE', "%" . $text . "%")
			->orWhere('failure_mode', 'LIKE', "%" . $text . "%");
	}

	public function scopeShow($query, $start, $take)
	{
		$query->skip($start)->take($take);
	}

	public static function last()
	{
		return Info::orderBy('id', 'desc')->first();
	}
// =========== MUTATORS ===================================

	/**
	 * set control number fomart before save
	 */
	public function setProblemDescriptionAttribute($value)
	{
		$this->attributes['problem_description'] = Str::title($value);
	}

	public function getProblemDescriptionAttribute($value)
	{
		return Str::title($value);
	}

	public function setDiscrepancyCategoryAttribute($value)
	{
		return $this->attributes['discrepancy_category'] = strtolower($value);
	}

	public function getDiscrepancyCategoryAttribute($value)
	{
		return Str::upper($value);
	}

	public function setFailureModeAttribute($value)
	{
		return $this->attributes['failure_mode'] = strtolower($value);
	}

	public function getFailureModeAttribute($value)
	{
		return Str::title($value);
	}

	public function setMachineAttribute($value)
	{
		return $this->attributes['machine'] = strtolower($value);
	}

	public function getMachineAttribute($value)
	{
		return Str::upper($value);
	}

	public function setCustomerAttribute($value)
	{
		return $this->attributes['customer'] = strtolower($value);
	}

	public function getCustomerAttribute($value)
	{
		return Str::upper($value);
	}

	public function setPackageTypeAttribute($value)
	{
		return $this->attributes['package_type'] = strtolower($value);
	}

	public function getPackageTypeAttribute($value)
	{
		return Str::upper($value);
	}

	public function setDeviceNameAttribute($value)
	{
		return $this->attributes['device_name'] = strtolower($value);
	}

	public function getDeviceNameAttribute($value)
	{
		return Str::upper($value);
	}

	public function setLotIdNumberAttribute($value)
	{
		return $this->attributes['lot_id_number'] = strtolower($value);
	}

	public function getLotIdNumberAttribute($value)
	{
		return Str::upper($value);
	}

	public function setStationAttribute($value)
	{
		return $this->attributes['station'] = strtolower($value);
	}

	public function getStationAttribute($value)
	{
		return Str::upper($value);
	}

	public function setJobOrderNumberAttribute($value)
	{
		return $this->attributes['job_order_number'] = strtolower($value);
	}

	public function getJobOrderNumberAttribute($value)
	{
		return Str::upper($value);
	}
}
