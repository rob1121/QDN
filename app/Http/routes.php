<?php

Route::group(['middleware' => 'web'], function () {

	Route::auth(); //login system routes

	foreach (File::allFiles(__DIR__ . '/Routes') as $key => $partial) {

		require_once $partial->getpathname();

	}

});
