<?php

namespace App\Listeners;

use App\Events\QdnClosedNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use Str;

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
		$involvePerson = $event->qdn->involvePerson;
		$closure       = $event->qdn->closure;
		$user          = $event->user->employee;
		$qdn           = $event->qdn;

		$data = [
			'qdn'           => $qdn,
			'involvePerson' => $involvePerson,
			'closure'       => $closure,
			'comment'       => $event->comment,
			'user'          => $user,
		];

		Mail::send('notifications.issue_qdn', $data, function ($message) use ($event) {
			$message->from('robinsonlegaspi@astigp.com', 'Rob');
			$message->replyTo('robinsonlegaspi@astigp.com', 'Rob');
			$message->sender('robinsonlegaspi@astigp.com', 'Rob');
			$message->to('robinsonlegaspi@astigp.com', 'Robinson Legaspi')
				->subject('QDN: ' . Str::title($event->qdn->problem_description) . ' - ' . $event->qdn->closure->status);
		});
	}
}
