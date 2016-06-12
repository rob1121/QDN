<?php
Route::group(['prefix' => 'dashboard/employees'], function () {
	Route::get('', [
		'as'   => 'EmployeesOptions',
		'uses' => 'Admin\Option\EmployeeController@EmployeesOptions']);

	Route::get('remove', [
		'as'   => 'removeEmployeesOptions',
		'uses' => 'Admin\Option\EmployeeController@removeEmployeesOptions']);

	Route::get('update', [
		'as'   => 'updateEmployeesOptions',
		'uses' => 'Admin\Option\EmployeeController@updateEmployeesOptions']);

	Route::get('store', [
		'as'   => 'newEmployeesOptions',
		'uses' => 'Admin\Option\EmployeeController@newEmployeesOptions']);

});