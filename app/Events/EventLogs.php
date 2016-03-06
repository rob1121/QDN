<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class EventLogs extends Event {
	public $user;
	public $action;
	public $comment;

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($user, $action, $comment = '') {

		$this->user    = $user;
		$this->action  = $action;
		$this->comment = $comment;
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
