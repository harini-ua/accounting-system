<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
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
        $verticalMenuData = config('menu.vertical');
        $horizontalMenuData = empty(config('menu.horizontal')) ? $verticalMenuData : config('menu.horizontal');

        // share all menuData to all the views
        \View::share('menuData',[
            'vertical' => $verticalMenuData,
            'horizontal' => $horizontalMenuData
        ]);
    }
}
