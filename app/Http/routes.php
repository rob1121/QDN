<?php

Route::group(['middleware' => 'web'], function () {
    Route::auth(); //login system routes
    Route::get("/login", "HomeController@index"); //override login redirect path

	foreach (File::allFiles(base_path() .	 '/app/repo/Routes') as $key => $partial) {

		require $partial->getpathname();

	}

});
