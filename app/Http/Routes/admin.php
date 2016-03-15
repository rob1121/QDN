<?php

Route::get('/dashboard', [
	'as'   => 'dashboard',
	'uses' => 'Admin\AdminController@index']);

Route::get('/qdn-metrics', [
	'as'   => 'QdnMetrics',
	'uses' => 'Admin\AdminController@QdnMetrics']);

Route::get('/pareto-of-discrepancy', [

	'as'   => 'ParetoOfDiscrepancy',
	'uses' => 'Admin\AdminController@ParetoOfDiscrepancy']);

Route::get('/pareto-per-failure-mode', [

	'as'   => 'ParetoPerFailureMode',
	'uses' => 'Admin\AdminController@ParetoPerFailureMode']);

Route::get('/dashboard/machines', [

	'as'   => 'MachineOptions',
	'uses' => 'Admin\AdminController@MachineOptions']);

Route::get('/failure-mode-option', [

	'as'   => 'FailureModeOptions',
	'uses' => 'Admin\AdminController@FailureModeOptions']);

Route::get('/discrepancy-category-options', [

	'as'   => 'DiscrepancyCategoryOptions',
	'uses' => 'Admin\AdminController@DiscrepancyCategoryOptions']);

Route::get('/customer-options', [

	'as'   => 'CustomerOptions',
	'uses' => 'Admin\AdminController@CustomerOptions']);

Route::get('/ajax-update-lead', [

	'as'   => 'UpdateLead',
	'uses' => 'Admin\AdminController@UpdateLead']);
