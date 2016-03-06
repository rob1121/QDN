<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLogs extends Model {
	protected $fillable = [
		'user_id',
		'name',
		'action',
		'comment',
		'ip',
	];

	// DEFINE RELATIONSHIPS --------------------------------------------------
	public function info() {
		return $this->belongsTo('App\Models\Info');
	}
}
