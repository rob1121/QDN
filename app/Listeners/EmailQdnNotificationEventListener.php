<?php
namespace App\Listeners;
use App\Events\EmailQdnNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use Str;

class EmailQdnNotificationEventListener implements ShouldQueue {
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
	 * @param  EmailQdnNotificationEvent  $event
	 * @return void
	 */
	public function handle(EmailQdnNotificationEvent $event) {
		$data = [
			'qdn' => $event->qdn,
		];
		Mail::send('notifications.issue_qdn', $data, function ($message) use ($event) {
			$message->from('robinsonlegaspi@astigp.com', 'Rob');
			$message->replyTo('robinsonlegaspi@astigp.com', 'Rob');
			$message->sender('robinsonlegaspi@astigp.com', 'Rob');
			$message->to('robinsonlegaspi@astigp.com', 'Robinson Legaspi')
				->subject('QDN: ' . Str::title($event->qdn->problem_description) . ' - ' . $event->qdn->closure->status);
		});
	}
}