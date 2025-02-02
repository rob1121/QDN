<?php

Route::get('/account/reset',
	[
		'as'   => 'reset',
		'uses' => 'Account\AccountPasswordController@index',
	]);

Route::post('/account/reset',
	[
		'as'   => 'reset',
		'uses' => 'Account\AccountPasswordController@postIndex',
	]);

Route::get('/account/question/{id}',
	[
		'as'   => 'question',
		'uses' => 'Account\AccountPasswordController@question',
	]);

Route::post('/account/question/{id}',
	[
		'as'   => 'question',
		'uses' => 'Account\AccountPasswordController@postQuestion',
	]);

Route::get('/account/new-password/{id}',
	[
		'as'   => 'password',
		'uses' => 'Account\AccountPasswordController@reset',
	]);

Route::post('/account/new-password/{id}',
	[
		'as'   => 'password',
		'uses' => 'Account\AccountPasswordController@postReset',
	]);

Route::get('/account/profile/{id}',
	[
		'as'   => 'profile',
		'uses' => 'Account\AccountPasswordController@profile',
	]);
Route::post('/account/save-profile/{id}',
	[
		'as'   => 'UpdateProfile',
		'uses' => 'Account\AccountPasswordController@UpdateProfile',
	]);