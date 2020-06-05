<?php

namespace App\Providers;

use App\Modules\Contract;
use App\Modules\Invoice;
use App\Observers\ContractObserver;
use App\Observers\InvoiceObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Contract::observe(ContractObserver::class);
        Invoice::observe(InvoiceObserver::class);
    }
}
