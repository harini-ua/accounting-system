<?php

namespace App\DataTables;

use App\Enums\Position;
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

        $dataTable->addColumn('total', static function(Person $model) {
            return view('pages.bonuses.table._total', compact('model'));
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
                $this->positionId = $this->request()->input('position_filter') ?? null;
                $query->where('position_id', $this->request->input('position_filter'));
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
        $paymentSums = DB::table('payments')
            ->select('invoice_id', DB::raw('sum(received_sum) AS total'))
            ->whereRaw("YEAR(payments.date)='$this->year'")
            ;

        //select `p`.id,
        //       `p`.name,
        //       count(`i`.`id`) as `invoices`,
        //       `payments`.`total`
        //from `people` as `p`
        //    join `invoices` as `i` on `i`.`sales_manager_id` = `p`.`id`
        //    left join (
        //        select `invoice_id`, SUM(received_sum) AS total
        //        from `payments`
        //        where YEAR(date)='2020'
        //    ) as `payments`
        //        on `payments`.`invoice_id` = `i`.`id`
        //where YEAR(`i`.`date`)='2020'
        //  and `p`.`bonuses` = 1
        //  and `p`.`position_id` in (5)
        //  and `p`.`deleted_at`is null
        //group by `p`.`name` asc
        //order by `p`.`name` asc
        //;

        $query = $model
            ->isBonuses()
            ->select(['people.*', 'payments.total'])
            ->join('invoices', 'invoices.sales_manager_id', '=', 'people.id')
            ->leftJoinSub($paymentSums, 'payments', static function($join) {
                $join->on('payments.invoice_id', '=', 'invoices.id');
            })
            ->whereIn('position_id', $this->positions)
            ->groupBy('people.name')
            ->orderBy('people.name')
            ->newQuery();

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
     * @return array
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function monthColumns()
    {
        $columns = [];
        foreach($this->period() as $month) {
            $columns[] = Column::make(strtolower($month->monthName))
//                ->title($month->shortMonthName)
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
        $monthColumns = [];
        foreach($this->period() as $month) {
            $monthName = strtolower($month->monthName);
            $monthColumns[] = $monthName;
            $dataTable->addColumn($monthName, static function(Person $model) use ($month, $monthName) {
                return view('pages.bonuses.table._month', compact('model', 'month'));
            });
        }

        return $monthColumns;
    }
}
