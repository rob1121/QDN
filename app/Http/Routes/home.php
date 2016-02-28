<?php

Route::get('/', [
	'as'   => 'home',
	'uses' => 'HomeController@index']); //home route

Route::get('/ajax',
	[
		'as'   => 'ajax',
		'uses' => 'homeController@ajax',
	]);

Route::get('/qdn-data',
	[
		'as'   => 'qdn_data',
		'uses' => 'homeController@qdnData',
	]);

Route::get('/status',
	[
		'as'   => 'status',
		'uses' => 'homeController@AjaxStatus',
	]);

Route::get('/count',
	[
		'as'   => 'counter',
		'uses' => 'homeController@counter',
	]);
