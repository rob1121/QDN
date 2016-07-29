<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use JavaScript;

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
			$server = "";
			// $server = "/qdn/public";
			JavaScript::put([
				'user' => $currentUser->load('Employee'),
				'env_server' => $server
				]);
			$view->with('show', 'process' == $currentUser->Employee->department || 'Admin' == $currentUser->access_level);

			$view->with('server', $server);

		}
	}

}