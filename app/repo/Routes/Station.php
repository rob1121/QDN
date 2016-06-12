<?php

Route::group(['prefix' => 'dashboard/stations'], function () {

    Route::get('', [
        'as'   => 'StationOptions',
        'uses' => 'Admin\Option\StationController@StationOptions']);

    Route::get('update', [
        'as'   => 'updateStationOptions',
        'uses' => 'Admin\Option\StationController@updateStationOptions']);

    Route::get('remove', [
        'as'   => 'removeStationOptions',
        'uses' => 'Admin\Option\StationController@removeStationOptions']);

});