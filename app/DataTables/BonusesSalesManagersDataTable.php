<?php

namespace App\DataTables;

use App\Enums\Currency;
use App\Enums\Position;
use App\Models\AccountType;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BonusesSalesManagersDataTable extends BonusesDataTableAbstract
{
    const COLUMNS = [
        'sales_manager',
        'bonus',
        'total',
    ];

    /** @var array */
    public $currency;

    /** @var mixed */
    public $year;

    /** @var mixed|null */
    public $positionId;

    /**
     * BonusesDataTable constructor.
     */
    public function __construct()
    {
        $this->currency = AccountType::all()->pluck('symbol', 'name')->toArray();
        $this->year = $this->request()->input('year_filter') ?? Carbon::now()->year;
        $this->positionId = Position::SalesManager;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Person $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Person $model)
    {
        $query = $model->newQuery();

        $query->select('people.id', 'people.name', 'people.bonuses_reward');

        $this->addMonthsSelect($query);
        $this->addTotalSelect($query);

        $monthsQuery = DB::table('invoices');
        $monthsQuery->select('sales_manager_id');

        $this->addMonthsSubSelect($monthsQuery);
        $this->addTotalSubSelect($monthsQuery);

        $monthsQuery->join('payments', 'invoices.id' , '=', 'payments.invoice_id');
        $monthsQuery->join('accounts', 'invoices.account_id', '=', 'accounts.id');
        $monthsQuery->join('account_types', 'accounts.account_type_id', '=', 'account_types.id');

        $monthsQuery->whereYear('payments.date', '=', $this->year);
        $monthsQuery->whereYear('invoices.date', '=', $this->year);
        $monthsQuery->groupBy('invoices.sales_manager_id');

        $query->leftJoinSub($monthsQuery, 'invoices', static function($join) {
            $join->on('invoices.sales_manager_id', '=', 'people.id');
        });

        $query->isBonuses();
        $query->where('people.position_id', Position::SalesManager);
        $query->whereNull('people.deleted_at');
        $query->where(function ($query) {
            $query->whereNull('people.quited_at');
            $query->orWhereYear('quited_at', $this->year);
        });
        $query->whereYear('people.start_date', '<=', $this->year);

        $query->groupBy('people.name');
        $query->orderBy('people.name');

        return $query;
    }

    /**
     * Add months select
     *
     * @param $query
     *
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    protected function addMonthsSelect($query): void
    {
        foreach($this->period() as $month) {
            $monthName = strtolower($month->monthName);

            $monthQuery = [];
            foreach (Currency::toArray() as $currency) {
                $monthQuery[$currency] = [
                    "',IFNULL(invoices.{$monthName}_{$currency}, 0),'",
                    "',IFNULL(invoices.{$monthName}_{$currency}/100*people.bonuses_reward, 0),'"
                ];
            }
            $concatJson = json_encode($monthQuery, JSON_UNESCAPED_SLASHES);
            $query->selectRaw("group_concat(concat('{$concatJson}')) as {$monthName}");
        }
    }

    /**
     * Add months sub select
     *
     * @param $query
     *
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    protected function addMonthsSubSelect($query): void
    {
        foreach($this->period() as $month) {
            $monthName = strtolower($month->monthName);

            foreach (Currency::toArray() as $currency) {
                $query->selectRaw("sum(case when month(payments.date)={$month->month} and account_types.name='{$currency}' then payments.received_sum end) as {$monthName}_{$currency}");
            }
        }
    }

    /**
     * Add total select
     *
     * @param $query
     */
    protected function addTotalSelect($query): void
    {
        $totalQuery = [];
        foreach (Currency::toArray() as $currency) {
            $totalQuery[$currency] = [
                "',IFNULL(invoices.total_{$currency}, 0),'",
                "',IFNULL(invoices.total_{$currency}/100*people.bonuses_reward, 0),'"
            ];
        }
        $concatJson = json_encode($totalQuery, JSON_UNESCAPED_SLASHES);
        $query->selectRaw("group_concat(concat('{$concatJson}')) as total");
    }

    /**
     * Add total sub select
     *
     * @param $query
     */
    protected function addTotalSubSelect($query): void
    {
        foreach (Currency::toArray() as $currency) {
            $query->selectRaw("sum(case when account_types.name='{$currency}' then payments.received_sum end) as total_{$currency}");
        }
    }
}
