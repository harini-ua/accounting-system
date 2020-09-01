<?php

namespace App\DataTables;

use App\Enums\Currency;
use App\Enums\Position;
use App\Models\AccountType;
use App\Models\Person;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BonusesDataTable extends DataTable
{
    const COLUMNS = [
        'person',
        'bonus',
        'total',
    ];

    /** @var array */
    public $currency;

    /** @var mixed */
    public $year;

    /** @var mixed|null */
    public $positionId;

    /** @var array */
    public $positions;

    /**
     * DataTables print preview view.
     *
     * @var string
     */
    protected $printPreview = '';

    /**
     * BonusesDataTable constructor.
     */
    public function __construct()
    {
        $this->currency = AccountType::all()->pluck('symbol', 'name')->toArray();
        $this->year = $this->request()->input('year_filter') ?? Carbon::now()->year;
        $this->positions = [
            Position::SalesManager,
//            Position::Recruiter
        ];
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = datatables()->eloquent($query);

        $dataTable->addColumn('person', static function (Person $model) {
            return view('partials.view-link', ['model' => $model]);
        });

        $dataTable->addColumn('bonus', static function(Person $model) {
            return $model->bonuses_reward . '%';
        });

        $dataTable->addColumn('total', function(Person $model) {
            $currency = $this->currency;
            $data = collect(json_decode($model->total, true));
            return view('pages.bonuses.table._total', compact('model', 'data', 'currency'));
        });

        $monthColumns = $this->addMonthColumnsToDatatable($dataTable);

        $dataTable->rawColumns(array_merge($monthColumns, self::COLUMNS));

        $dataTable->filterColumn('person', static function($query, $keyword) {
            $query->where('name', 'like', "%$keyword%");
        });

        $dataTable->filter(function($query) {
            if ($this->request->has('year_filter')) {
//                $query->join('clients', 'contracts.client_id', '=', 'clients.id')
//                    ->where('clients.id', '=', $this->request->input('client_filter'));
            }
            if ($this->request->has('position_filter')) {
                $this->positionId = $this->request()->input('position_filter');
                $query->where('position_id', $this->positionId);
            }
        }, true);

        $dataTable->orderColumn('person', static function($query, $order) {
            $query->orderBy('name', $order);
        });

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Person $model
     *
     * @return \Illuminate\Database\Query\Builder
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
        $query->whereIn('people.position_id', $this->positions);
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
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('bonuses-list-datatable')
            ->addTableClass('table responsive-table cell-border highlight row-border')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
            ->scrollX()
            ->scrollCollapse(true)
            ->fixedColumnsLeftColumns(3)
            ->fixedColumnsRightColumns(1)
            ->parameters([
                'columnDefs' => [
                    ['targets' => [1,2], 'className' => 'fixed'],
                    ['targets' => [15], 'className' => 'fixed'],
                ]
            ])
        ;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $firstColumns[] = Column::make('id')->hidden();
        $firstColumns[] = Column::make('person')->orderable(true);
        $firstColumns[] = Column::make('bonus')->title(__('Bonus'))->orderable(false);

        $monthColumns = $this->monthColumns();

        $lastColumns[] = Column::make('total')->orderable(false);

        return array_merge($firstColumns, $monthColumns, $lastColumns);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Bonuses_' . date('YmdHis');
    }

    /**
     * @return CarbonPeriod
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function period()
    {
        return CarbonPeriod::create(Carbon::createFromDate($this->year)->startOfYear(), '1 month', Carbon::createFromDate($this->year)->endOfYear());
    }

    /**
     * Add months select
     *
     * @param $query
     */
    private function addMonthsSelect($query): void
    {
        foreach($this->period() as $month) {
            $monthName = strtolower($month->monthName);

            $monthQuery = [];
            foreach (Currency::toArray() as $currency) {
                $monthQuery[$currency] = [
                    "',IFNULL(invoices.{$monthName}_$currency, 0),'",
                    "',IFNULL(invoices.{$monthName}_$currency/100*people.bonuses_reward, 0),'"
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
     */
    private function addMonthsSubSelect($query): void
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
    private function addTotalSelect($query): void
    {
        $totalQuery = [];
        foreach (Currency::toArray() as $currency) {
            $totalQuery[$currency] = [
                "',IFNULL(invoices.total_$currency, 0),'",
                "',IFNULL(invoices.total_$currency/100*people.bonuses_reward, 0),'"
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
    private function addTotalSubSelect($query): void
    {
        foreach (Currency::toArray() as $currency) {
            $query->selectRaw("sum(case when account_types.name='{$currency}' then payments.received_sum end) as total_{$currency}");
        }
    }

    /**
     * @return array
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function monthColumns(): array
    {
        $columns = [];
        foreach($this->period() as $month) {
            $columns[] = Column::make(strtolower($month->monthName))
                ->title(view('pages.bonuses.table._head', compact('month'))->render())
                ->orderable(false)
                ->searchable(false);
        }

        return $columns;
    }

    /**
     * @param $dataTable
     * @return array
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function addMonthColumnsToDatatable($dataTable): array
    {
        $currency = $this->currency;

        $monthColumns = [];
        foreach($this->period() as $month) {
            $monthName = strtolower($month->monthName);
            $monthColumns[] = $monthName;
            $dataTable->addColumn($monthName, static function(Person $model) use ($month, $monthName, $currency) {
                $data = collect(json_decode($model->{$monthName}, true));
                return view('pages.bonuses.table._month', compact('data', 'currency', 'month'));
            });
        }

        return $monthColumns;
    }
}
