<?php

namespace App\DataTables;

use App\Models\Person;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PaymentsGridDataTable extends DataTable
{
    public $year;

    /**
     * ContractsDataTable constructor.
     */
    public function __construct()
    {
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
        $eloquent = datatables()
            ->eloquent($query)
            ->addColumn('name', function(Person $model) {
                return view('partials.view-link', ['model' => $model]);
            })
            ->orderColumn('name', function($query, $order) {
                $query->orderBy('name', $order);
            })
        ;

        $this->addMonthColumnsToDatatable($eloquent);

        return $eloquent;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Payment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Person $model)
    {
        $query = $model->newQuery()
            ->select(['people.id', 'people.name', 'people.start_date', 'people.quited_at'])
            ->join('salary_payments', 'salary_payments.person_id', '=', 'people.id')
            ->join('calendar_months', 'salary_payments.calendar_month_id', '=', 'calendar_months.id')

            ->join('accounts', 'accounts.id', '=', 'salary_payments.person_id')
            ->join('wallets', 'wallets.id', '=', 'accounts.wallet_id')

            ->whereNull('salary_payments.deleted_at')
            ->groupBy('people.id')
            ->orderBy('people.name')
        ;

        $this->addMonthsSelect($query);
        $this->addFilterQuery($query);

        return $query;
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
            ->setTableId('payment-grid-list-datatable')
            ->addTableClass('table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
            ->languageSearch('Search')
            ->languageSearchPlaceholder('Person')
            ->orderBy(0);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $firstColumns = [
            Column::make('name'),
        ];
        $monthColumns = $this->monthColumns();

        return array_merge($firstColumns, $monthColumns);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Payment-grid_' . date('YmdHis');
    }

    /**
     * @param $query
     *
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function addMonthsSelect($query)
    {
        foreach($this->period() as $month) {
            $columnName = strtolower($month->monthName);
            $query->selectRaw("case when calendar_months.name = '{$month->monthName}' then wallets.name end as {$columnName}");
        }
    }

    /**
     * @param $query
     */
    private function addFilterQuery($query)
    {
        $query->when($this->request()->input('search.value'), function($query, $search) {
            $query->where('people.name', 'like', "%$search%");
        })
        ->when($this->request()->input('year_filter'), function($query, $year) {
            $query->whereYear('start_date', '<=', $year)
                ->where(function($query) use ($year) {
                    $query->whereNull('quited_at')
                        ->orWhereYear('quited_at', $year);
                });
        }, function($query) {
            $year = Carbon::now()->year;
            $query->whereYear('start_date', '<=', $year)
                ->where(function($query) use ($year) {
                    $query->whereNull('quited_at')
                        ->orWhereYear('quited_at', $year);
                });
        })
        ;
    }

    /**
     * @return CarbonPeriod
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function period()
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
    private function monthColumns()
    {
        $columns = [];

        foreach($this->period() as $month) {
            $columns[] = Column::make(strtolower($month->monthName))
                ->title("<a class='text-decoration-underline' data-month-link href='"
                        .route('salaries.month', [$this->year, $month->month])."'>{$month->shortMonthName}</a>")
                ->searchable(false)
                ->orderable(false);
        }

        return $columns;
    }

    /**
     * @param $eloquent
     *
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function addMonthColumnsToDatatable($eloquent)
    {
        $rawColumns = [];

        foreach($this->period() as $month) {
            $monthName = strtolower($month->monthName);
            $rawColumns[] = $monthName;
            $eloquent->addColumn($monthName, function(Person $model) use ($month, $monthName) {
                return $model->$monthName;
            });
        }

        $eloquent->rawColumns($rawColumns);
    }
}
