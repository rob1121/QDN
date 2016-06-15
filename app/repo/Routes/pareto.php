<?php

Route::get('/pareto',
[
    'as'   => 'pareto',
    'uses' => 'paretoController@pareto'
]);

Route::get('/pareto-ajax',
[
    'as'   => 'paretoAjax',
    'uses' => 'paretoController@paretoAjax'
]);

Route::get('/pareto/excel',
[
        'as' => 'admin.pareto.excel',
    'uses' => 'paretoController@excel'
]);