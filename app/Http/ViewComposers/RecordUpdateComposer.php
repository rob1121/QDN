<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Employee;
class RecordUpdateComposer {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $view->with('disposition_check', [
            'use as is',
            'ncmr#',
            'rework',
            'split lot',
            'shutdown',
            'shipback',
        ]);

        $view->with('cod_check', [
            'production',
            'process',
            'maintenance',
            'facilities',
            'quality assurance',
            'others'
        ]);

        $view->with('names', Employee::all('name'));

    }

}