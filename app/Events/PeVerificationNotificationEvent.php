<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class PeVerificationNotificationEvent extends Event {
	use SerializesModels;
	public $qdn;
	public $logger;
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($qdn, $logger) {
		$this->qdn    = $qdn;
		$this->logger = $logger;
		// $this->qdn = collect($qdn->load('involvePerson'))->put('msg', $msg)->all();
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
