<?php
namespace App\Http\ViewComposers;

use App\Employee;
use App\OptionModels\Machine;
use App\OptionModels\Option;
use App\OptionModels\Station;
use Illuminate\Contracts\View\View;

class FormOptionComposer {

	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view) {

		$view->with('select_failure_mode', [
			'assembly',
			'environment',
			'machine',
			'man',
			'material',
			'method / process',
		]);

		$view->with('customers', Option::all('customer'));
		$view->with('machines', Machine::all('name'));
		$view->with('stations', Station::all('station'));
		$view->with('employees', Employee::all('name'));

	}

}