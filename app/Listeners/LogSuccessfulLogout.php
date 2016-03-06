<?php

namespace App\Listeners;

use App\Models\EventLogs;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Request;

class LogSuccessfulLogout implements ShouldQueue {
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
	 * @param  Logout  $event
	 * @return void
	 */
	public function handle(Logout $event) {
		$employee = $event->user->employee;
		EventLogs::create([
			'user_id' => $employee->user_id,
			'name'    => $employee->name,
			'action'  => 'sign out',
			'ip'      => Request::ip(),
		]);
	}
}
