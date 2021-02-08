<?php

namespace App\DataTables;

use App\Enums\Currency;
use App\Models\Person;
use App\Services\Formatter;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SalaryDataTable extends DataTable
{
    public $year;
    private $currency;

    /**
     * VacationsDataTable constructor.
     */
    public function __construct()
    {
        $this->year = $this->request()->input('year_filter') ?? Carbon::now()->year;
        $this->currency = $this->request()->input('currency_filter') ?? Currency::USD;
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
            // definitions
            ->addColumn('name', function(Person $model) {
                return view('partials.view-link', ['model' => $model]);
            })
            ->addColumn('total', function(Person $model) {
                return $model->total ? Formatter::currency(round($model->total, 2), Currency::symbol($this->currency)) : null;
            })
            // orders
            ->orderColumn('name', function($query, $order) {
                $query->orderBy('name', $order);
            });

        $this->addMonthColumnsToDatatable($eloquent);

        return $eloquent;
    }

    /**
     * Get query source of dataTable.
     *
     * @param Person $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Person $model)
    {
        $totalColumn = $this->currency == Currency::UAH ? 'total_usd * salary_payments.currency' : 'total_usd';
        $query = $model->newQuery()
            ->select(['people.id', 'people.name', 'people.start_date', 'people.quited_at'])
            ->selectRaw("sum($totalColumn) as total")
            ->join('salary_payments', 'salary_payments.person_id', '=', 'people.id')
            ->join('calendar_months', 'salary_payments.calendar_month_id', '=', 'calendar_months.id')
            ->whereNull('salary_payments.deleted_at')
            ->groupBy('people.id')
            ->orderBy('people.name');
        $this->addMonthsSelect($query);
        $this->addLongVacationMonthQuery($query);
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
            ->setTableId('salary-table')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
            ->pageLength(10)
            ->ordering(false)
            ->drawCallback("function() {
                $(this).find('thead th a[data-month-link]').attr('href', function(i, val) {
                    let year = window.filters.get('year_filter') || (new Date()).getFullYear();
                    return val.replace(/\/(\d+)\//, function() {
                        return '/' + year + '/';
                    });
                });
                $(this).find('td span[data-color]').each(function() {
                    $(this).closest('td').attr('style', 'background-color: ' + $(this).attr('data-color') + ' !important;');
                });
            }");
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
        $lastColumns = [
            Column::make('total')->searchable(false),
        ];

        return array_merge($firstColumns, $monthColumns, $lastColumns);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Salary_' . date('YmdHis');
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
            });

        if (!$this->request()->filled('show_all')) {
            $query->whereNull('people.quited_at');
        }
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
     * @param $query
     *
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function addMonthsSelect($query)
    {
        foreach($this->period() as $month) {
            $columnName = strtolower($month->monthName);
            if ($this->currency == Currency::UAH) {
                $query->selectRaw("sum(case when calendar_months.name = '{$month->monthName}' then total_usd * salary_payments.currency end) as {$columnName}");
            } else {
                $query->selectRaw("sum(case when calendar_months.name = '{$month->monthName}' then total_usd end) as {$columnName}");
            }
        }
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
                ->searchable(false);
        }

        return $columns;
    }

    /**
     * @param $query
     *
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function addLongVacationMonthQuery($query)
    {
        $longVacationsQuery = DB::table('long_vacations')
            ->select('person_id')
            ->groupBy('person_id');

        foreach($this->period() as $month) {
            $monthName = strtolower($month->monthName);
            $longVacationsQuery->selectRaw("
                sum(case
                    when (year(long_vacation_started_at)='{$month->year}' or year(long_vacation_finished_at)='{$month->year}')
                    and long_vacation_started_at <= '{$month->startOfMonth()}'
                    and (
                        long_vacation_finished_at is null
                        or long_vacation_finished_at >= '{$month->endOfMonth()}'
                    )
                then 1 else 0 end) as long_vacation_$monthName
            ");
        }

        $query->leftJoinSub($longVacationsQuery, 'long_vacations', function($join) {
            $join->on('long_vacations.person_id', '=', 'people.id');
        });
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
                if ($model->quited_at) {
                    $quitedAt = Carbon::parse($model->quited_at);
                    if ($month->year == $quitedAt->year && $month > $quitedAt) {
                        return '<span data-color="#eeeeee"></span>';
                    }
                }

                if ($model->{"long_vacation_$monthName"}) {
                    return '<span data-color="#e7feff"></span>';
                }

                $startDate = Carbon::parse($model->start_date)->startOfMonth();
                if ($month->year == $startDate->year && $month < $startDate) {
                    return '<span data-color="#f5f2ff"></span>';
                }

                return $model->$monthName ? Formatter::currency(round($model->$monthName, 2), Currency::symbol($this->currency)) : null;
            });
        }

        $eloquent->rawColumns($rawColumns);
    }
}
