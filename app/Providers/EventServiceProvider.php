<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'App\Events\EmailQdnNotificationEvent'       => [
			'App\Listeners\EmailQdnNotificationEventListener',
		],
		'App\Events\PeVerificationNotificationEvent' => [
			'App\Listeners\PeVerificationNotificationEventListener',
		],
		'App\Events\ApprovalNotificationEvent'       => [
			'App\Listeners\ApprovalNotificationEventListener',
		],
		'App\Events\QaVerificationNotificationEvent' => [
			'App\Listeners\QaVerificationNotificationEventListener',
		],
		'App\Events\QdnClosedNotificationEvent'      => [
			'App\Listeners\QdnClosedNotificationEventListener',
		],
		'App\Events\EventLogs'                       => [
			'App\Listeners\EventLogsListener',
		],

		'Illuminate\Auth\Events\Attempting'          => [
			'App\Listeners\LogAuthenticationAttempt',
		],

		'Illuminate\Auth\Events\Login'               => [
			'App\Listeners\LogSuccessfulLogin',
		],

		'Illuminate\Auth\Events\Logout'              => [
			'App\Listeners\LogSuccessfulLogout',
		],

		'Illuminate\Auth\Events\Lockout'             => [
			'App\Listeners\LogLockout',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events) {
		parent::boot($events);
		$events->listen('event.name', function ($foo, $bar) {
		});
	}
}
