<?php

namespace App\Listeners;

use App\Events\QaVerificationNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class QaVerificationNotificationEventListener implements ShouldQueue {
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
	 * @param  QaVerificationNotificationEvent  $event
	 * @return void
	 */
	public function handle(QaVerificationNotificationEvent $event) {
		//
	}
}
