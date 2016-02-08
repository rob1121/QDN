<?php

Route::get('/', 'HomeController@index'); //home route

Route::get('/ajax',
[
    'as'   => 'ajax',
    'uses' => 'homeController@ajax'
]);

Route::get('/qdn-data',
[
    'as'   => 'qdn_data',
    'uses' => 'homeController@qdnData'
]);

Route::get('status',
[
    'as'   => 'status',
    'uses' => 'homeController@AjaxStatus'
]);