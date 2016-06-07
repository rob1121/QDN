<?php

namespace App\Models;

use Carbon;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use DB;
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

	// DEFINE RELATIONSHIPS --------------------------------------------------
	public function causeOfDefect() {
		return $this->hasOne('App\Models\CauseOfDefect');
	}
	public function containmentAction() {
		return $this->hasOne('App\Models\ContainmentAction');
	}

	public function correctiveAction() {
		return $this->hasOne('App\Models\CorrectiveAction');
	}

	public function preventiveAction() {
		return $this->hasOne('App\Models\PreventiveAction');
	}

	public function qdnCycle() {
		return $this->hasOne('App\Models\Qdncycle');
	}

	public function closure() {
		return $this->hasOne('App\Models\Closure');
	}

	public function involvePerson() {
		return $this->hasMany('App\Models\InvolvePerson');
	}

	public function eventLog() {
		return $this->hasMany('App\Models\EventLogs');
	}

	public function getRouteKeyName() {
		return 'slug';
	}

	/**
	 * retrieving data from table for BMP graphs
	 * @param $query
	 * @param $month
	 * @param $year
	 * @param string $select
	 * @return
	 */
	public function scopePod($query, $month, $year, $select = 'all') {
		if ('' == $select || 'all' == $select) {
			return $query->select(DB::raw(
				'COUNT(discrepancy_category) as paretoFirst,
                    discrepancy_category as category'
			))
				->groupBy('discrepancy_category')
				->where(DB::raw('MONTH(created_at)'), $month ? '=' : 'LIKE', $month ? $month : '%%')
				->where(DB::raw('YEAR(created_at)'), $year)
				->get();

		}

		if ('failureMode' == $select) {

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

	/**
	 * get qdndata for year round
	 */
	public function scopeQdn($query, $year) {
		$query->select(
			DB::raw('
                    MONTH(created_at) as month,
                    COUNT(MONTH(created_at)) as count
                ')
		)
			->where(DB::raw('YEAR(created_at)'), $year)
			->groupBy('month');
	}
	
	function scopeIssued($query, $date) {
		collect([
			'today' => $query->where( DB::raw('DATE_FORMAT(created_at, "%m-%d-%Y")'), "=", Carbon::now('Asia/Manila')->format('m-d-Y'))->get(),
			'week' => $query->where( DB::raw('WEEK(created_at)'), "=", Carbon::now('Asia/Manila')->weekOfYear )->get(),
			'month' => $query->where( DB::raw('MONTH(created_at)'), "=", Carbon::now('Asia/Manila')->month )->where(DB::raw('YEAR(created_at)'),"=",Carbon::now('Asia/Manila')->year)->get(),
			'year' => $query->where(DB::raw('YEAR(created_at)'), "=", Carbon::now('Asia/Manila')->year)->get()
		])->get($date);
	}

	public function scopeSearch($query, $text) {
		$query->where('problem_description', 'LIKE', "%" . $text . "%")
			->orWhere('discrepancy_category', 'LIKE', "%" . $text . "%")
			->orWhere('control_id', 'LIKE', "%" . $text . "%")
			->orWhere('customer', 'LIKE', "%" . $text . "%")
			->orWhere('station', 'LIKE', "%" . $text . "%")
			->orWhere('failure_mode', 'LIKE', "%" . $text . "%");
	}
    
	public function scopeShow($query, $start, $take) {
		$query->skip($start)->take($take);
	}
    
	public function scopeIsExist($query, $request) {
		$query->whereCustomer($request->customer)
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
			->whereQuantity($request->quantity);
	}
// =========== MUTATORS ===================================

	/**
	 * set control number fomart before save
	 */
	public function setProblemDescriptionAttribute($value) {
		$this->attributes['problem_description'] = strtolower($value);
	}

	public function getProblemDescriptionAttribute($value) {
		return Str::title($value);
	}

	public function setDiscrepancyCategoryAttribute($value) {
		return $this->attributes['discrepancy_category'] = strtolower($value);
	}

	public function getDiscrepancyCategoryAttribute($value) {
		return Str::upper($value);
	}

	public function setFailureModeAttribute($value) {
		return $this->attributes['failure_mode'] = strtolower($value);
	}

	public function getFailureModeAttribute($value) {
		return Str::title($value);
	}

	public function setMachineAttribute($value) {
		return $this->attributes['machine'] = strtolower($value);
	}

	public function getMachineAttribute($value) {
		return Str::upper($value);
	}

	public function setCustomerAttribute($value) {
		return $this->attributes['customer'] = strtolower($value);
	}

	public function getCustomerAttribute($value) {
		return Str::upper($value);
	}

	public function setPackageTypeAttribute($value) {
		return $this->attributes['package_type'] = strtolower($value);
	}

	public function getPackageTypeAttribute($value) {
		return Str::upper($value);
	}

	public function setDeviceNameAttribute($value) {
		return $this->attributes['device_name'] = strtolower($value);
	}

	public function getDeviceNameAttribute($value) {
		return Str::upper($value);
	}

	public function setLotIdNumberAttribute($value) {
		return $this->attributes['lot_id_number'] = strtolower($value);
	}

	public function getLotIdNumberAttribute($value) {
		return Str::upper($value);
	}

	public function setStationAttribute($value) {
		return $this->attributes['station'] = strtolower($value);
	}

	public function getStationAttribute($value) {
		return Str::upper($value);
	}

	public function setJobOrderNumberAttribute($value) {
		return $this->attributes['job_order_number'] = strtolower($value);
	}

	public function getJobOrderNumberAttribute($value) {
		return Str::upper($value);
	}

	public function setControlIdAttribute($value) {
		$today = Carbon::now('Asia/Manila');
		$year = $today->format('y');
        
		return $this->attributes['control_id'] = $year . "-" . sprintf("%'.04d", $value);
	}
}
