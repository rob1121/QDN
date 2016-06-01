<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class InvolvePerson extends Model {
	protected $fillable = [
		'info_id',
		'station',
		'originator_id',
		'originator_name',
		'receiver_id',
		'receiver_name',
	];

	// DEFINE RELATIONSHIPS --------------------------------------------------
	public function info() {
		return $this->belongsTo('App\Models\Info');
	}

	public function setDepartmentAttribute($value) {
		return $this->attributes['department'] = strtolower($value);
	}

	public function getDepartmentAttribute($value) {
		return Str::upper($value);
	}

}
