<?php

// CRUD route of QDN
Route::get('/report',
[
    'as'   => 'issue_qdn',
    'uses' => 'reportController@report'
]);

Route::post('/report',
[
    'as'   => 'issue_qdn',
    'uses' => 'reportController@store'
]);

Route::get('/report/{slug}',
[
    'as'   => 'qdn_link',
    'uses' => 'reportController@show'
]);

Route::post('/draft/{slug}',
[
    'as'   => 'draft_link',
    'uses' => 'reportController@draft'
]);

Route::post('/approval/{slug}',
[
    'as'   => 'approval_link',
    'uses' => 'reportController@approval'
]);


Route::get('/report/{slug}/pdf',
[
    'as'   => 'pdf',
    'uses' => 'reportController@pdf'
]);

   
