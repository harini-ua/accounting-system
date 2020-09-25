<?php

namespace App\Providers;

use App\Classes\Toast;
use App\Models\CalendarYear;
use App\Models\Contract;
use App\Models\Holiday;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\SalaryReview;
use App\Observers\CalendarYearObserver;
use App\Models\InvoiceItem;
use App\Observers\ContractObserver;
use App\Observers\HolidayObserver;
use App\Observers\InvoiceItemObserver;
use App\Observers\InvoiceObserver;
use App\Observers\OfferObserver;
use App\Observers\SalaryReviewObserver;
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
        InvoiceItem::observe(InvoiceItemObserver::class);
        Invoice::observe(InvoiceObserver::class);
        CalendarYear::observe(CalendarYearObserver::class);
        Holiday::observe(HolidayObserver::class);
        Offer::observe(OfferObserver::class);
        SalaryReview::observe(SalaryReviewObserver::class);
    }
}
