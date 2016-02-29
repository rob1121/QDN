<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PeVerificationNotificationEvent extends Event {
	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($qdn, $msg) {
		$data = ['qdn' => array_add($qdn, 'msg', $msg)];
		Mail::send('notifications.pe_verification', $data, function ($message) use ($qdn) {
			$message->from('robinsonlegaspi@astigp.com', 'Rob');
			$message->replyTo('robinsonlegaspi@astigp.com', 'Rob');
			$message->sender('robinsonlegaspi@astigp.com', 'Rob');
			$message->to('robinsonlegaspi@astigp.com', 'Robinson Legaspi')
				->subject('QDN - ' . $qdn->problem_description . ' - Subject for Completion');
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
