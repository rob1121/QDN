<?php

namespace App\Listeners;

use App\Events\ApprovalNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ApprovalNotificationEventListener implements ShouldQueue {
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
	 * @param  ApprovalNotificationEvent  $event
	 * @return void
	 */
	public function handle(ApprovalNotificationEvent $event) {
		//
	}
}
