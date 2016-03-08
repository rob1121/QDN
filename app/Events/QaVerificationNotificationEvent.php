<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class QaVerificationNotificationEvent extends Event {
	use SerializesModels;
	public $qdn;
	public $comment;
	public $user;
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($qdn, $request = '') {
		$this->qdn     = $qdn;
		$this->comment = $request;
		$this->user    = Auth::user();
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
