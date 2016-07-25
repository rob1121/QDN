<?php namespace App\repo\API;

use App\Models\Closure;

class QdnCountAndData
{
	public function getStatus() {
		$statuses =  [
			[
				'count' => static::getCount('p.e. verification'),
			 	'link' => 'peVerification',
			 	'status' => 'P.E. Verification',
			 	'id' => 'text-peVerification'
		 	],

			[
				'count' => static::getCount('incomplete fill-up'),
			 	'link' => 'incomplete',
			 	'status' => 'Incomplete fill-up',
			 	'id' => 'text-incomplete'
		 	],

			[
				'count' => static::getCount('incomplete approval'),
			 	'link' => 'approval',
			 	'status' => 'Incomplete approval',
			 	'id' => 'text-approval'
		 	],

			[
				'count' => static::getCount('q.a. verification'),
			 	'link' => 'qaVerification',
			 	'status' => 'Q.A. Verification',
			 	'id' => 'text-qaVerification'
		 	]
		];

		return $statuses;
	}

	public static function getCount($status) {
		return Closure::where('status', $status)->count();
	}
}