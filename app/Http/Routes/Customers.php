<?php

Route::group(['prefix' => 'dashboard/customers'], function () {
	Route::get('', [
		'as'   => 'CustomerOptions',
		'uses' => 'Admin\Option\CustomerController@CustomerOptions']);

	Route::get('update', [
		'as'   => 'updateCustomerOptions',
		'uses' => 'Admin\Option\CustomerController@updateCustomerOptions']);

	Route::get('remove', [
		'as'   => 'removeCustomerOptions',
		'uses' => 'Admin\Option\CustomerController@removeCustomerOptions']);
});