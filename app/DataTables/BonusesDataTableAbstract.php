<?php

namespace App\DataTables;

use App\Models\AccountType;
use App\Models\Person;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

abstract class BonusesDataTableAbstract extends DataTable
{
    public const COLUMNS = [
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
     *
     * @return \Yajra\DataTables\DataTableAbstract
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    public function dataTable($query)
    {
        $dataTable = datatables()->eloquent($query);

        $dataTable->addColumn('person', function (Person $model) {
            //$personUrl = route("bonuses.person.show", $model->id).'?'.Arr::query(['year' => $this->year]);
            //return '<a target="_blank" href="'.$personUrl.'">'.$model->name.'</a>';
            return view('partials.view-link', ['model' => $model]);
        });

        $dataTable->addColumn('bonus', static function(Person $model) {
            return $model->bonuses_reward . '%';
        });

        $dataTable->addColumn('total', function(Person $model) {
            return view('pages.bonuses.partials.table._total', [
                'model' => $model,
                'positionId' => $this->positionId,
                'data' => collect(json_decode($model->total, true)),
                'currency' => $this->currency,
                'year' => $this->year
            ]);
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
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     * @throws \Throwable
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
//            ->scrollX()
//            ->scrollCollapse(true)
//            ->fixedColumnsLeftColumns(3)
//            ->fixedColumnsRightColumns(1)
            ->parameters([
                'columnDefs' => [
                    ['targets' => [1], 'className' => 'fixed'],
                    ['targets' => [2], 'className' => 'fixed center-align green-text large-text'],
                    ['targets' => [3,4,5,6,7,8,9,10,11,12,13,14], 'className' => 'small-text'],
                    ['targets' => [15], 'className' => 'fixed'],
                ]
            ])
        ;
    }

    /**
     * Get columns.
     *
     * @return array
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    protected function getColumns()
    {
        $firstColumns[] = Column::make('id')->hidden();
        $firstColumns[] = Column::make('person')->orderable(false);
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
    protected function period()
    {
        return CarbonPeriod::create(
            Carbon::createFromDate($this->year)->startOfYear(),
            '1 month',
            Carbon::createFromDate($this->year)->endOfYear()
        );
    }

    /**
     * @return array
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    protected function monthColumns(): array
    {
        $columns = [];
        $year = $this->year;
        $folderView = str_replace(' ', '-', strtolower(\App\Enums\Position::getDescription($this->positionId)));

        foreach($this->period() as $month) {
            $columns[] = Column::make(strtolower($month->monthName))
                ->title(view('pages.bonuses.partials.table._head', compact('month', 'year'))->render())
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
    protected function addMonthColumnsToDatatable($dataTable): array
    {
        $monthColumns = [];
        foreach($this->period() as $month) {
            $monthName = strtolower($month->monthName);
            $monthColumns[] = $monthName;
            $dataTable->addColumn($monthName, function(Person $model) use ($month, $monthName) {
                return view('pages.bonuses.partials.table._month', [
                    'model' => $model,
                    'positionId' => $this->positionId,
                    'data' => collect(json_decode($model->{$monthName}, true)),
                    'currency' => $this->currency,
                    'month' => $month,
                    'year' => $this->year
                ]);
            });
        }

        return $monthColumns;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Person $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract public function query(Person $model);

    /**
     * Add months select
     *
     * @param $query
     * @return void
     */
    abstract protected function addMonthsSelect($query) :void;

    /**
     * Add months sub select
     *
     * @param $query
     * @return void
     */
    abstract protected function addMonthsSubSelect($query) :void;

    /**
     * Add total select
     *
     * @param $query
     * @return void
     */
    abstract protected function addTotalSelect($query) :void;

    /**
     * Add total sub select
     *
     * @param $query
     * @return void
     */
    abstract protected function addTotalSubSelect($query) :void;
}
