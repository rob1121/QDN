<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class GlobalComposer {

	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view) {
		$view->with('currentUser', Auth::user());
		$view->with('show', Auth::user()->Employee->department == 'process' || Auth::user()->access_level == 'Admin');
	}

}