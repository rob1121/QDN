<?php

Route::get('/dashboard', [
	'as'   => 'dashboard',
	'uses' => 'Admin\AdminController@index']);

Route::get('/dashboard/machines', [

	'as'   => 'MachineOptions',
	'uses' => 'Admin\AdminController@MachineOptions']);

Route::get('/dashboard/machines-update', [
	'as'   => 'updateMachineOptions',
	'uses' => 'Admin\AdminController@updateMachineOptions']);

Route::get('/dashboard/machines-remove', [
	'as'   => 'removeMachineOptions',
	'uses' => 'Admin\AdminController@removeMachineOptions']);

Route::get('/failure-mode-option', [

	'as'   => 'FailureModeOptions',
	'uses' => 'Admin\AdminController@FailureModeOptions']);

Route::get('/discrepancy-category-options', [

	'as'   => 'DiscrepancyCategoryOptions',
	'uses' => 'Admin\AdminController@DiscrepancyCategoryOptions']);

Route::get('/dashboard/customers', [

	'as'   => 'CustomerOptions',
	'uses' => 'Admin\AdminController@CustomerOptions']);

Route::get('/dashboard/customers-update', [
	'as'   => 'updateCustomerOptions',
	'uses' => 'Admin\AdminController@updateCustomerOptions']);

Route::get('/dashboard/customers-remove', [
	'as'   => 'removeCustomerOptions',
	'uses' => 'Admin\AdminController@removeCustomerOptions']);

Route::get('/dashboard/employees', [

	'as'   => 'EmployeesOptions',
	'uses' => 'Admin\AdminController@EmployeesOptions']);

Route::get('/dashboard/employees-remove', [
	'as'   => 'removeEmployeesOptions',
	'uses' => 'Admin\AdminController@removeEmployeeOptions']);

Route::get('/dashboard/employees-update', [
	'as'   => 'updateEmployeesOptions',
	'uses' => 'Admin\AdminController@updateEmployeesOptions']);

Route::get('/dashboard/employees-filter', [
	'as'   => 'filterEmployeesOptions',
	'uses' => 'Admin\AdminController@filterEmployeesOptions']);

Route::get('/ajax-update-lead', [

	'as'   => 'UpdateLead',
	'uses' => 'Admin\AdminController@UpdateLead']);
