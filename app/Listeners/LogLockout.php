<?php

namespace App\Listeners;

use App\Models\EventLogs;
use Illuminate\Auth\Events\Lockout;
use Request;

class LogLockout {
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  Lockout  $event
	 * @return void
	 */
	public function handle(Lockout $event) {
		$login = $event->request;
		EventLogs::create([
			'user_id' => $login->employee_id,
			'action'  => 'attemp failed',
			'comment' => 'PWD: ' . $login->password,
			'ip'      => Request::ip(),
		]);
	}
}
