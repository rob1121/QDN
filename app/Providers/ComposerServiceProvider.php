<?php
namespace App\Providers;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

	/**
	 * Register bindings in the container.
	 *
	 * @return void
	 */
	public function boot(ViewFactory $view) {
		$view->composer('*', 'App\Http\ViewComposers\GlobalComposer');
		$view->composer(
			['report.create', 'report.view', 'report.IncompleteApproval', 'report.incomplete', 'report.QaVerification'],
			'App\Http\ViewComposers\FormOptionComposer'
		);
		$view->composer(
			['report.view', 'pdf.print', 'report.IncompleteApproval', 'report.incomplete', 'report.QaVerification'],
			'App\Http\ViewComposers\RecordUpdateComposer'
		);

		$view->composer('home', 'App\Http\ViewComposers\HomeComposer');
		$view->composer(['home.pareto', 'admin.pages.index'], 'App\Http\ViewComposers\HomeComposer');
	}

	public function register() {
		//
	}

}
