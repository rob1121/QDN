<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class EventLogs extends Event {
	public $action;
	public $comment;
	public $user;

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($action, $comment = '') {
		$this->action  = $action;
		$this->comment = $comment;
		$this->user    = Auth::user()->employee;
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
