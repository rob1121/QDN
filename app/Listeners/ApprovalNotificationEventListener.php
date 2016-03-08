<?php

namespace App\Listeners;

use App\Events\ApprovalNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Str;

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
		$involvePerson = $event->qdn->involvePerson;
		$closure       = $event->qdn->closure;
		$user          = $event->user->employee;
		$qdn           = $event->qdn;
		$data          = [
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
				->subject('QDN: ' . Str::title($event->qdn->problem_description . ' - ' . $event->qdn->closure->status));
		});
	}
}
