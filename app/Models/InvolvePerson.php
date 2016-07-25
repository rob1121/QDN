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

	public function setStationAttribute($value) {
		return $this->attributes['station'] = strtolower($value);
	}

	public function getStationAttribute($value) {
		return Str::upper($value);
	}

	public static function store($id, $person)
	{
	    InvolvePerson::create([
			'info_id' => $id,
			'station' => $person->station,
			'originator_id' => user()->employee_id,
			'originator_name' => user()->employee->name,
			'receiver_id' => $person->user_id,
			'receiver_name' => $person->name,
		]);
	}

	public static function getInvolvePerson($id) {
		return InvolvePerson::whereInfoId($id)->get(['receiver_name','station']);
	}

}
