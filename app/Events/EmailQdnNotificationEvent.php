<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Str;

class EmailQdnNotificationEvent extends Event {
	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($qdn) {
		$qdn->load('involvePerson');
		$data = [
			'qdn' => $qdn,
		];
		Mail::send('notifications.issue_qdn', $data, function ($message) use ($qdn) {
			$message->from('robinsonlegaspi@astigp.com', 'Rob');
			$message->replyTo('robinsonlegaspi@astigp.com', 'Rob');
			$message->sender('robinsonlegaspi@astigp.com', 'Rob');
			$message->to('robinsonlegaspi@astigp.com', 'Robinson Legaspi')
				->subject('QDN - ' . Str::title($qdn->problem_description) . ' - Subject for PE Verification');
		});
	}

	/**
	 * Get the channels the event should be broadcast on.
	 *
	 * @return array
	 */
	public function broadcastOn() {
		return [];
	}
}
