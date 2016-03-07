<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class QaVerificationNotificationEvent extends Event {
	use SerializesModels;
	public $qdn;
	public $msg;
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($qdn, $msg = '') {
		$this->qdn = $qdn->load('involvePerson');
		$this->msg = $msg;
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
