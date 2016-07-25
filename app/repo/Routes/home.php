<?php

Route::get('/home', [
	'as'   => 'home',
	'uses' => 'HomeController@home']); //home route

Route::get('/', [
	'as'   => 'welcome',
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
		'as'   => 'getQdnLinkAndData',
		'uses' => 'homeController@getQdnLinkAndData',
	]);

Route::get('/count',
	[
		'as'   => 'counter',
		'uses' => 'homeController@counter',
	]);
