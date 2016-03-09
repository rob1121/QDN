<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

	// DEFINE RELATIONSHIPS --------------------------------------------------
	public function info() {
		return $this->belongsTo('App\Models\Info');
	}

	public function scopeStatus($query, $status) {
		$query->where('status', $status);
	}

	//mutators===============================================================

	public function setProductionAttribute($value) {
		return $this->attributes['production'] = strtolower($value);
	}

	public function getProductionAttribute($value) {
		return $this->attributes['production'] = Str::title($value);
	}

	public function setProcessEngineeringAttribute($value) {
		return $this->attributes['process_engineering'] = strtolower($value);
	}

	public function getProcessEngineeringAttribute($value) {
		return $this->attributes['process_engineering'] = Str::title($value);
	}

	public function setQualityAssuranceAttribute($value) {
		return $this->attributes['quality_assurance'] = strtolower($value);
	}

	public function getQualityAssuranceAttribute($value) {
		return $this->attributes['quality_assurance'] = Str::title($value);
	}

	public function setOtherDepartmentAttribute($value) {
		return $this->attributes['other_department'] = strtolower($value);
	}

	public function getOtherDepartmentAttribute($value) {
		return $this->attributes['other_department'] = Str::title($value);
	}
}
