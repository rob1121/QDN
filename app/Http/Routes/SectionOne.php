<?php

Route::get('/report/{slug}/verified',
	[
		'as'   => 'SectionOneSaveAndProceed',
		'uses' => 'ActionController@SectionOneSaveAndProceed',
	]);

Route::get('/report/{slug}/ajax',
	[
		'as'   => 'SectionOneSaveAsDraft',
		'uses' => 'ActionController@SectionOneSaveAsDraft',
	]);

//====================== section two =======================

Route::get('/report/incomplete/{slug}',
	[
		'as'   => 'ForIncompleteFillUp',
		'uses' => 'ActionController@ForIncompleteFillUp',
	]);
//====================== qdn closure section =======================

Route::get('/report/qa-verification/{slug}',
	[
		'as'   => 'qa_verification',
		'uses' => 'ActionController@QaVerification',
	]);
Route::post('/report/qa-verification/{slug}',
	[
		'as'   => 'qa_verification',
		'uses' => 'ActionController@QaVerification',
	]);