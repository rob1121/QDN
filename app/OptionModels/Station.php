<?php

namespace App\OptionModels;

use Illuminate\Database\Eloquent\Model;
use Str;

class Station extends Model {
	protected $fillable = ['station', 'department'];

	public function setStationAttribute($value) {
		return $this->attributes['station'] = strtolower($value);
	}
	public function getStationAttribute($value) {
		return Str::upper($value);
	}
	public function setDepartmentAttribute($value) {
		return $this->attributes['department'] = strtolower($value);
	}
	public function getDepartmentAttribute($value) {
		return Str::upper($value);
	}
}
