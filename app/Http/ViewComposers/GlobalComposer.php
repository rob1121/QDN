<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use JavaScript;

class GlobalComposer {
	protected $_CurrentUser;
	protected $_View;
	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view) {
		$this->_View = $view;
		$this->globalServerVariable();
		$this->globalUserVariable();

		if ($this->isUserLogin()) {
			$this->setupUserVariableForJavaScript();
			$this->_View->with('show', $this->isUserDepartmentEqualsToProcess());
		}
	}

		protected function globalServerVariable() {
			$server = "";
			// $server = "/qdn/public";
			$this->_View->with('server', $server);
			JavaScript::put(['env_server' => $server]);
		}

		protected function globalUserVariable() {
			$this->_CurrentUser = Auth::user();
			$this->_View->with('currentUser', $this->_CurrentUser);
		}

		protected function isUserLogin() {
			return $this->_CurrentUser;
		}

		protected function setupUserVariableForJavaScript() {
			JavaScript::put(['user' => $this->_CurrentUser->load('Employee')]);
		}

		protected function isUserDepartmentEqualsToProcess() {
			return 'process' == $this->_CurrentUser->Employee->department ||
				'Admin' == $this->_CurrentUser->access_level;
		}


}