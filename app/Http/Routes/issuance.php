<?php

// CRUD route of QDN
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

Route::get('/report/{slug}',
	[
		'as'   => 'qdn_link',
		'uses' => 'reportController@show',
	]);

Route::get('/report/{slug}/store',
	[
		'as'   => 'qdn_link_post',
		'uses' => 'reportController@peVerification',
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

Route::get('report/approval/{slug}',
	['as'  => 'approval',
		'uses' => 'reportController@approval']);
