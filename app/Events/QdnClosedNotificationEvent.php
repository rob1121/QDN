<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class QdnClosedNotificationEvent extends Event {
	use SerializesModels;
	public $qdn;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($qdn) {
		$qdn->load('involvePerson');
		$this->qdn = $qdn;
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
