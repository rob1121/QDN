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
		return $this->hasOne('App\Models\CauseOfDefect'); // this matches the Eloquent model
	}
	public function containmentAction() {
		return $this->hasOne('App\Models\ContainmentAction'); // this matches the Eloquent model
	}

	public function correctiveAction() {
		return $this->hasOne('App\Models\CorrectiveAction'); // this matches the Eloquent model
	}

	public function preventiveAction() {
		return $this->hasOne('App\Models\PreventiveAction'); // this matches the Eloquent model
	}

	public function qdnCycle() {
		return $this->hasOne('App\Models\Qdncycle'); // this matches the Eloquent model
	}

	public function closure() {
		return $this->hasOne('App\Models\Closure'); // this matches the Eloquent model
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
				->where(DB::raw('MONTH(created_at)'), $month)
				->where(DB::raw('YEAR(created_at)'), $year)
				->get();

		}

		return $query->select(DB::raw(
			'COUNT(failure_mode) as paretoFirst,
                failure_mode as category'
		))
			->groupBy('failure_mode')
			->where(DB::raw('MONTH(created_at)'), $month)
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

	/**
	 * get qdndata for year round
	 */
	public function scopeIssued($query, $date) {
		switch ($date) {
		case 'today':
			$query->where(
				DB::raw('DATE_FORMAT(created_at, "%m-%d-%Y")'),
				"=",
				Carbon::now('Asia/Manila')->format('m-d-Y')
			)->get();
			break;
		case 'week':
			$query->where(
				DB::raw('WEEK(created_at)'),
				"=",
				Carbon::now('Asia/Manila')->weekOfYear
			)->get();
			break;
		case 'month':
			$query->where(
				DB::raw('MONTH(created_at)'),
				"=",
				Carbon::now('Asia/Manila')->month
			)
				->where(
					DB::raw('YEAR(created_at)'),
					"=",
					Carbon::now('Asia/Manila')->year
				)->get();
			break;
		case 'year':
			$query->where(
				DB::raw('YEAR(created_at)'),
				"=",
				Carbon::now('Asia/Manila')->year
			)->get();
			break;
		}
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
		$query->skip($start)
			->take($take);
	}
	public function scopeIsExist($query, $request) {
		$query->whereCustomer($request->customer)
			->wherePackage_type($request->package_type)
			->whereDevice_name($request->device_name)
			->whereLot_id_number($request->lot_id_number)
			->whereLot_quantity($request->lot_quantity)
			->whereJob_order_number($request->job_order_number)
			->whereMachine($request->machine)
			->whereStation($request->station)
			->whereMajor($request->major)
			->whereProblem_description($request->problem_description)
			->whereFailure_mode($request->failure_mode)
			->whereDiscrepancy_category($request->discrepancy_category)
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
		$today                                 = Carbon::now('Asia/Manila');
		$year                                  = $today->format('y');
		return $this->attributes['control_id'] = $year . "-" . sprintf("%'.04d", $value);
	}
}
