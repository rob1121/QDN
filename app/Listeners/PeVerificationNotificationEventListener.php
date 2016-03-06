<?php

namespace App\Listeners;

use App\Events\PeVerificationNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PeVerificationNotificationEventListener implements ShouldQueue {
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
	 * @param  PeVerificationNotificationEvent  $event
	 * @return void
	 */
	public function handle(PeVerificationNotificationEvent $event) {
		//
	}
}
