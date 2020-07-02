<?php

namespace App\Providers;

use App\Models\Contract;
use App\Models\Invoice;
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
