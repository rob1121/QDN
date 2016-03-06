<?php

namespace App\Listeners;

use App\Events\EventLogs;
use App\Models\EventLogs as Logs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Request;

class EventLogsListener implements ShouldQueue {
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
	 * @param  EventLogs  $event
	 * @return void
	 */
	public function handle(EventLogs $event) {
		$user = $event->user;
		Logs::create([
			'user_id' => $user->employee_id,
			'name'    => $user->employee->name,
			'action'  => $event->action,
			'comment' => $event->comment,
			'ip'      => Request::ip(),
		]);
	}
}
