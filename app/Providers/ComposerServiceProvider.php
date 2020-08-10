<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\Composers\NotFoundComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('errors::404', NotFoundComposer::class);
    }
}