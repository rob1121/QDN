<?php

Route::get('/issue',
	[
		'as'   => 'create',
		'uses' => 'reportController@create',
	]);

Route::get('/report',
	[
		'as'   => 'issue_qdn',
		'uses' => 'reportController@report',
	]);

Route::post('/report',
	[
		'as'   => 'issue_qdn',
		'uses' => 'reportController@store',
	]);

Route::get('/home/success',
	[
		'as'   => 'issue_success',
		'uses' => 'reportController@returnHome',
	]);

Route::get('/form',
	[
		'as'   => 'qdn_form',
		'uses' => 'reportController@form',
	]);
Route::get('/report/{slug}',
	[
		'as'   => 'qdn_link',
		'uses' => 'reportController@show',
	]);

Route::post('/draft/{slug}',
	[
		'as'   => 'draft_link',
		'uses' => 'reportController@draft',
	]);

Route::post('/approval/{slug}',
	[
		'as'   => 'approval_link',
		'uses' => 'reportController@forApproval',
	]);

Route::get('/report/{slug}/pdf',
	[
		'as'   => 'pdf',
		'uses' => 'reportController@pdf',
	]);

Route::get('/report/approval/{slug}',
	['as'  => 'approval',
		'uses' => 'reportController@approval']);

Route::post('report/approval/{slug}',
	['as'  => 'UpdateForApprroval',
		'uses' => 'reportController@UpdateForApprroval']);

Route::get('/report/refresh/{slug}',
	['as'  => 'refresher',
		'uses' => 'reportController@CacheRefresher']);

Route::get('/report/forget/{slug}',
	['as'  => 'forget',
		'uses' => 'reportController@ForgetCache']);