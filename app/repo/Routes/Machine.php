<?php

Route::group(['prefix' => 'dashboard/machines'], function () {

	Route::get('', [
		'as'   => 'MachineOptions',
		'uses' => 'Admin\Option\MachineController@MachineOptions']);

	Route::get('update', [
		'as'   => 'updateMachineOptions',
		'uses' => 'Admin\Option\MachineController@updateMachineOptions']);

	Route::get('remove', [
		'as'   => 'removeMachineOptions',
		'uses' => 'Admin\Option\MachineController@removeMachineOptions']);

});