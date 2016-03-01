<?php
namespace App\Http\ViewComposers;

use App\Employee;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth as Auth;

class RecordUpdateComposer {

	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view) {

		$view->with('disposition_check', [
			'use as is',
			'ncmr#',
			'rework',
			'split lot',
			'shutdown',
			'shipback',
		]);

		$view->with('cod_check', [
			'production',
			'process',
			'maintenance',
			'facilities',
			'quality assurance',
			'others',
		]);

		$view->with('approvers', [
			'production',
			'process',
			'quality assurance',
			'others',
		]);

		$view->with('names', Employee::select('name')
				->orderBy('name')
				->where('name', '<>', Auth::User()->employee->name)
				->get());

	}

}