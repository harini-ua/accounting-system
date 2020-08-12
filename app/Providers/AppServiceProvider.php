<?php

namespace App\Providers;

use App\Models\CalendarYear;
use App\Models\Contract;
use App\Models\Invoice;
use App\Observers\CalendarYearObserver;
use App\Observers\ContractObserver;
use App\Observers\InvoiceObserver;
use App\Services\FilterService;
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
        $this->app->singleton(FilterService::class);
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
        CalendarYear::observe(CalendarYearObserver::class);
    }
}
