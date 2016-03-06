<?php

namespace App\Listeners;

use App\Events\EmailQdnNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailQdnNotificationEventListener implements ShouldQueue {
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
	 * @param  EmailQdnNotificationEvent  $event
	 * @return void
	 */
	public function handle(EmailQdnNotificationEvent $event) {
		//
	}
}
