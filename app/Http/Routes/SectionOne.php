<?php

Route::get('/report/{slug}/verified',
	[
		'as' => 'sectionOneSaveAsDraft',
		'uses' => 'ActionController@SectionOneSaveAndProceed',
	]);

Route::get('/report/{slug}/ajax',
	[
		'as' => 'section_one_ajax',
		'uses' => 'ActionController@SectionOneSaveAsDraft',
	]);
