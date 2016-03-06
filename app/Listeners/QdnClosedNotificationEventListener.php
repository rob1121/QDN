<?php

namespace App\Listeners;

use App\Events\QdnClosedNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class QdnClosedNotificationEventListener implements ShouldQueue {
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
	 * @param  QdnClosedNotificationEvent  $event
	 * @return void
	 */
	public function handle(QdnClosedNotificationEvent $event) {
		//
	}
}
