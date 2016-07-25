<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Closure extends Model {

	protected $fillable = [
		'info_id',
		'containment_action_taken',
		'corrective_action_taken',
		'close_by',
		'date_sign',
		'production',
		'process_engineering',
		'quality_assurance',
		'other_department',
		'pe_verified_by',
		'status',
	];

	public static function statusCount($status)
	{
		return Closure::status($status)->count();
	}

    public static function status($status) {
        return Closure::with('info')->whereStatus($status)->get();
    }

	// DEFINE RELATIONSHIPS --------------------------------------------------
	public function info() {
		return $this->belongsTo('App\Models\Info');
	}

	//mutators===============================================================

	public function setProductionAttribute($value) {
		return $this->attributes['production'] = strtolower($value);
	}

	public function getProductionAttribute($value) {
		return Str::title($value);
	}

	public function setProcessEngineeringAttribute($value) {
		return $this->attributes['process_engineering'] = strtolower($value);
	}

	public function getProcessEngineeringAttribute($value) {
		return Str::title($value);
	}

	public function setQualityAssuranceAttribute($value) {
		return $this->attributes['quality_assurance'] = strtolower($value);
	}

	public function getQualityAssuranceAttribute($value) {
		return Str::title($value);
	}

	public function setOtherDepartmentAttribute($value) {
		return $this->attributes['other_department'] = strtolower($value);
	}

	public function getOtherDepartmentAttribute($value) {
		return Str::title($value);
	}

	public function setStatusAttribute($value) {
		return $this->attributes['status'] = strtolower($value);
	}

	public function getStatusAttribute($value) {
		return Str::title($value);
	}
}
