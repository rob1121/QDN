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
     * EmailQdnNotificationEventListener constructor.
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
	public function handle(EmailQdnNotificationEvent $event)
    {
        $data = [
            'qdn' => $event->qdn,
            'involvePerson' => $event->qdn->involvePerson,
            'closure' => $event->qdn->closure,
            'comment' => $event->comment,
            'user' => $event->user->employee,
        ];
        Mail::send('notifications.issue_qdn', $data, function ($message) use ($event) {
            $message->from('robinsonlegaspi@astigp.com', 'Rob');
            $message->replyTo('robinsonlegaspi@astigp.com', 'Rob');
            $message->sender('robinsonlegaspi@astigp.com', 'Rob');
            $message->to('robinsonlegaspi@astigp.com', 'Robinson Legaspi');
//            $message->to('janicerodolfo@astigp.com', 'Janice Rodolfo');
//            $message->to('rosalysanchez@astigp.com', 'Rosaly Sanchez');
//            $message->to('alexanderalmonte@astigp.com', 'Alexander Almonte');
//            $message->to('jakeparambita@astigp.com', 'Jake Parambita');
            $message->subject('QDN: ' . Str::title($event->qdn->problem_description) . ' - ' . $event->qdn->closure->status);
        });
    }
}