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
		'status',
	];

	// DEFINE RELATIONSHIPS --------------------------------------------------
	public function info() {
		return $this->belongsTo('App\Models\Info');
	}

	public function scopeStatus($query, $status) {
		$query->where('status', $status);
	}
}
