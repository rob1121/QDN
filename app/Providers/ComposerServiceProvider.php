<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;
class ComposerServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot(ViewFactory $view)
    {
        $view->composer('*', 'App\Http\ViewComposers\GlobalComposer');
        $view->composer('report.create', 'App\Http\ViewComposers\FormOptionComposer');
        $view->composer('report.view', 'App\Http\ViewComposers\RecordUpdateComposer');
    }

    public function register()
    {
        //
    }

}