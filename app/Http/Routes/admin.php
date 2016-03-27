<?php

Route::get('/dashboard', [
	'as'   => 'dashboard',
	'uses' => 'Admin\AdminController@index']);

Route::get('/ajax-update-lead', [

	'as'   => 'UpdateLead',
	'uses' => 'Admin\AdminController@UpdateLead']);
