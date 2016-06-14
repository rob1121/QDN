<?php

Route::group(['prefix' => 'api'], function () {
    Route::get('/cycle-time', [
        'as'   => 'cycleTime',
        'uses' => 'Api\ApiController@cycleTime']);

    Route::get('/cycle-time-average', [
        'as'   => 'cycleTimeAverage',
        'uses' => 'Api\ApiController@cycleTimeAverage']);

    Route::get('/cycle-time-pareto', [
        'as'   => 'cycleTimePareto',
        'uses' => 'Api\ApiController@cycleTimePareto']);

    Route::get('/station-pie-data', [
        'as'   => 'stationPie',
        'uses' => 'Api\ApiController@stationPie']);
});