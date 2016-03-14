<?php

namespace App\OptionModels;

use Illuminate\Database\Eloquent\Model;
use Str;

class Machine extends Model {
	protected $fillable = ['name'];

	public function setNameAttribute($value) {
		return $this->attributes['name'] = strtolower($value);
	}
	public function getNameAttribute($value) {
		return $this->attributes['name'] = Str::upper($value);
	}
}