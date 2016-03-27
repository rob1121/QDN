<?php

Route::group(['prefix' => 'dashboard/discrepancy'], function () {

    Route::get('', [
        'as'   => 'discrepancy',
        'uses' => 'Admin\Option\DiscrepancyController@discrepancy']);

    Route::get('update', [
        'as'   => 'updateDiscrepancy',
        'uses' => 'Admin\Option\DiscrepancyController@updateDiscrepancy']);

    Route::get('remove', [
        'as'   => 'removeDiscrepancy',
        'uses' => 'Admin\Option\DiscrepancyController@removeDiscrepancy']);

});