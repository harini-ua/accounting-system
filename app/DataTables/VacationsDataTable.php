<?php

namespace App\DataTables;

use App\Enums\VacationPaymentType;
use App\Models\Person;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VacationsDataTable extends DataTable
{
    private $year;

    /**
     * VacationsDataTable constructor.
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
            // definitions
            ->addColumn('name', function(Person $model) {
                return $model->payment == VacationPaymentType::Paid ? view('partials.view-link', ['model' => $model]) : '';
            })
            ->addColumn('start_date', function(Person $model) {
                return $model->payment == VacationPaymentType::Paid ? $model->start_date : null;
            })
            ->addColumn('quited_at', function(Person $model) {
                return $model->payment == VacationPaymentType::Paid ? $model->quited_at : null;
            })
            ->addColumn('available_vacations', function(Person $model) {
                return $model->payment == VacationPaymentType::Paid ? $model->available_vacations : null;
            })
            ->addColumn('total', function(Person $model) {
                return $model->total ?? 0;
            })
            ->addColumn('compensation_days', function(Person $model) {
                return null; //todo: resolve after implementation payslip
            })
            ->addColumn('compensation_date', function(Person $model) {
                return null; //todo: resolve after implementation payslip
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
        $paidVacations = DB::table('vacations')
            ->select('person_id')
            ->selectRaw('count(id) as total')
            ->where('payment_type',VacationPaymentType::Paid)
            ->groupBy('person_id');
        $this->addMonthsQuery($paidVacations);

        $unpaidVacations = DB::table('vacations')
            ->select('person_id')
            ->selectRaw('count(id) as total')
            ->where('payment_type',VacationPaymentType::Unpaid)
            ->groupBy('person_id');
        $this->addMonthsQuery($unpaidVacations);

        $paidQuery = $model->newQuery()
            ->select('people.*', 'paid_vacations.total', 'long_vacations.*')
            ->selectRaw("'".VacationPaymentType::Paid."' as payment")
            ->leftJoinSub($paidVacations, 'paid_vacations', function($join) {
                $join->on('paid_vacations.person_id', '=', 'people.id');
            });
        $this->addLongVacationMonthQuery($paidQuery);
        $this->addFilterQuery($paidQuery);

        $unpaidQuery = $model->newQuery()
            ->select('people.*', 'unpaid_vacations.total', 'long_vacations.*')
            ->selectRaw("'".VacationPaymentType::Unpaid."' as payment")
            ->leftJoinSub($unpaidVacations, 'unpaid_vacations', function($join) {
                $join->on('unpaid_vacations.person_id', '=', 'people.id');
            });
        $this->addLongVacationMonthQuery($unpaidQuery);
        $this->addFilterQuery($unpaidQuery);

        return $unpaidQuery
            ->unionAll($paidQuery)
            ->orderBy('name')
            ->orderBy('payment');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('vacations-table')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
            ->pageLength(20)
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
            }")
            ;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $firstColumns = [
            Column::make('name')->searchable(true),
            Column::make('start_date')->title('Date of the work beginning')->searchable(false),
            Column::make('quited_at')->title('Date of dismissal')->searchable(false),
            Column::make('payment')->searchable(false),
            Column::make('available_vacations')->title('Available in total')->searchable(false),
            Column::make('total')->title('Total in fact')->searchable(false),
        ];
        $monthColumns = $this->monthColumns();
        $lastColumns = [
            Column::make('compensation_days')->searchable(false),
            Column::make('compensation_date')->searchable(false),
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
        return 'Vacations_' . date('YmdHis');
    }

    /**
     * @return CarbonPeriod
     */
    private function period()
    {
        return CarbonPeriod::create(Carbon::createFromDate($this->year)->startOfYear(), '1 month', Carbon::createFromDate($this->year)->endOfYear());
    }

    /**
     * @param $query
     */
    private function addMonthsQuery($query)
    {
        foreach($this->period() as $month) {
            $monthName = strtolower($month->monthName);
            $query->selectRaw("count(case when month(date)={$month->month} then id end) as {$monthName}");
        }
    }

    /**
     * @param $query
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
     * @return array
     */
    private function monthColumns()
    {
        $columns = [];
        foreach($this->period() as $month) {
            $columns[] = Column::make(strtolower($month->monthName))
                ->title("<a data-month-link href='".route('vacations.month', [$this->year, $month->month])."'>{$month->shortMonthName}</a>")
                ->searchable(false);
        }
        return $columns;
    }

    /**
     * @param $eloquent
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
                return $model->$monthName ?: 0;
            });
        }
        $eloquent->rawColumns($rawColumns);
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
    }
}
