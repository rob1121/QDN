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


		$currentUser = Auth::user();
		$view->with('currentUser', $currentUser);
		if ($currentUser) {
			$view->with('show', 'process' == $currentUser->Employee->department || 'Admin' == $currentUser->access_level);
		}
	}

}