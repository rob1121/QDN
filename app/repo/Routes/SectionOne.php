<?php

Route::get('/report/{slug}/verified',
	[
		'as'   => 'SectionOneSaveAndProceed',
		'uses' => 'reportController@SectionOneSaveAndProceed',
	]);

Route::get('/report/{slug}/ajax',
	[
		'as'   => 'SectionOneSaveAsDraft',
		'uses' => 'reportController@SectionOneSaveAsDraft',
	]);

//====================== section two =======================

Route::get('/report/incomplete/{slug}',
	[
		'as'   => 'ForIncompleteFillUp',
		'uses' => 'reportController@ForIncompleteFillUp',
	]);
//====================== qdn closure section =======================

Route::get('/report/qa-verification/{slug}',
	[
		'as'   => 'qa_verification',
		'uses' => 'reportController@QaVerification',
	]);

Route::post('/report/qa-verification/{slug}',
	[
		'as'   => 'QaVerificationUpdate',
		'uses' => 'reportController@QaVerificationUpdate',
	]);