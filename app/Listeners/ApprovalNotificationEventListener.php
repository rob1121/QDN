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
		$data = ['qdn' => $event->qdn, 'msg' => $event->msg];
		Mail::send('notifications.pe_verification', $data, function ($message) use ($event) {
			$message->from('robinsonlegaspi@astigp.com', 'Rob');
			$message->replyTo('robinsonlegaspi@astigp.com', 'Rob');
			$message->sender('robinsonlegaspi@astigp.com', 'Rob');
			$message->to('robinsonlegaspi@astigp.com', 'Robinson Legaspi')
				->subject('QDN: ' . Str::title($event->qdn->problem_description) . ' - ' . $event->qdn->closure->status);
		});
	}
}
