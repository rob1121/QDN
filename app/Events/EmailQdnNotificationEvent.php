<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Info;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailQdnNotificationEvent extends Event {
	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct() {

		$table = Info::all();
		$data = [
			'table' => $table,
		];
		Mail::send('notifications.issue_qdn', $data, function ($message) {
			$message->from('robinsonlegaspi@astigp.com', 'Rob');
			$message->replyTo('robinsonlegaspi@astigp.com', 'Rob');
			$message->sender('robinsonlegaspi@astigp.com', 'Rob');
			$message->to('robinsonlegaspi@astigp.com', 'Robinson Legaspi')
				->subject('123');
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
