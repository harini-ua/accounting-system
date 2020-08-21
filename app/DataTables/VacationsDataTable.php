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
            ->select('people.*', 'paid_vacations.*')
            ->selectRaw("'".VacationPaymentType::Paid."' as payment")
            ->leftJoinSub($paidVacations, 'paid_vacations', function($join) {
                $join->on('paid_vacations.person_id', '=', 'people.id');
            });
        $this->addFilterQuery($paidQuery);

        $unpaidQuery = $model->newQuery()
            ->select('people.*', 'unpaid_vacations.*')
            ->selectRaw("'".VacationPaymentType::Unpaid."' as payment")
            ->leftJoinSub($unpaidVacations, 'unpaid_vacations', function($join) {
                $join->on('unpaid_vacations.person_id', '=', 'people.id');
            });
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
            ->ordering(false);
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
        return CarbonPeriod::create(Carbon::now()->startOfYear(), '1 month', Carbon::now()->endOfYear());
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
     * @return array
     */
    private function monthColumns()
    {
        $year = $this->request()->input('year_filter') ?? Carbon::now()->year;
        $columns = [];
        foreach($this->period() as $month) {
            $columns[] = Column::make(strtolower($month->monthName))
                ->title("<a data-month-link href='".route('vacations.month', [$year, $month->month])."'>{$month->shortMonthName}</a>")
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
            $eloquent->addColumn($monthName, function(Person $model) use ($monthName) {
                return $model->$monthName ?: '<span data-color="red"></span>';
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
