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

class BonusesRecruitersDataTable extends DataTable
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
            return view('pages.bonuses.table.recruiter._total', compact('model', 'data', 'currency'));
        });

        $monthColumns = $this->addMonthColumnsToDatatable($dataTable);

        $dataTable->rawColumns(array_merge($monthColumns, self::COLUMNS));

        $dataTable->filterColumn('person', static function($query, $keyword) {
            $query->where('name', 'like', "%$keyword%");
        });

        $dataTable->filter(function($query) {
            if ($this->request->has('year_filter')) {
                $this->year = $this->request()->input('year_filter') ?? Carbon::now()->year;
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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Person $model)
    {
        $query = $model->newQuery();

        $query->select('people.id', 'people.name', 'people.bonuses_reward');

        $this->addMonthsSelect($query);
        $this->addTotalSelect($query);

        $monthsQuery = DB::table('people');
        $monthsQuery->select('recruiter_id');

        $this->addMonthsSubSelect($monthsQuery);
        $this->addTotalSubSelect($monthsQuery);

        $monthsQuery->groupBy('recruiter_id');

        $query->leftJoinSub($monthsQuery, 'hired', static function($join) {
            $join->on('hired.recruiter_id', '=', 'people.id');
        });

        $query->isBonuses();
        $query->where('people.position_id', Position::Recruiter);
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
                    "',IFNULL(hired.{$monthName}_first_{$currency}/100*(people.bonuses_reward/2),0),'",
                    "',IFNULL(hired.{$monthName}_second_{$currency}/100*(people.bonuses_reward/2),0),'"
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
                $query->selectRaw("sum(case when month(start_date)={$month->month} and year(start_date)='{$this->year}' and currency='{$currency}' then salary end) as {$monthName}_first_{$currency}");
                $query->selectRaw("sum(case when month(date_add(date_add(start_date, interval 2 month), interval 1 day))={$month->month} and year(date_add(date_add(start_date, interval 2 month), interval 1 day))='{$this->year}' and currency='{$currency}' then salary end) as {$monthName}_second_{$currency}");
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
                "',IFNULL(hired.total_first_{$currency}/100*(people.bonuses_reward/2),0),'",
                "',IFNULL(hired.total_second_{$currency}/100*(people.bonuses_reward/2),0),'"
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
            $query->selectRaw("sum(case when year(start_date)='{$this->year}' and currency='{$currency}' then salary end) as total_first_{$currency}");
            $query->selectRaw("sum(case when year(date_add(date_add(start_date, interval 2 month), interval 1 day))='{$this->year}' and currency='{$currency}' then salary end) as total_second_{$currency}");
        }
    }

    /**
     * @return array
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function monthColumns(): array
    {
        $columns = [];
        $year = $this->year;
        foreach($this->period() as $month) {
            $columns[] = Column::make(strtolower($month->monthName))
                ->title(view('pages.bonuses.table.recruiter._head', compact('month', 'year'))->render())
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
                return view('pages.bonuses.table.recruiter._month', compact('data', 'currency', 'month'));
            });
        }

        return $monthColumns;
    }
}
