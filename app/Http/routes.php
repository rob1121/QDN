<?php

Route::group(['middleware' => 'web'], function () {

	Route::auth(); //login system routes

	foreach (File::allFiles(base_path() .	 '/app/repo/Routes') as $key => $partial) {

		require $partial->getpathname();

	}

});
