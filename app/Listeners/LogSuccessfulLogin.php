<?php

namespace App\Listeners;

use App\Models\EventLogs;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Request;

class LogSuccessfulLogin implements ShouldQueue {
	use InteractsWithQueue;
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
	 * @param  Login  $event
	 * @return void
	 */
	public function handle(Login $event) {
		$employee = $event->user->employee;
		EventLogs::create([
			'user_id' => $employee->user_id,
			'name'    => $employee->name,
			'action'  => 'sign in',
			'ip'      => Request::ip(),
		]);

	}
}
