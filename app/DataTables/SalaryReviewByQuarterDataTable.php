<?php

namespace App\DataTables;

use App\Enums\Currency;
use App\Models\Person;
use App\Models\SalaryReview;
use App\Services\Formatter;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SalaryReviewByQuarterDataTable extends DataTable
{
    const COLUMNS = [
        'person',
        'basic_salary',
        'total',
        'salary',
    ];

    /** @var mixed */
    public $year;

    /**
     * OffersDataTables constructor.
     */
    public function __construct()
    {
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

        $dataTable->addColumn('person', static function (SalaryReview $model) {
            return view('partials.view-link', ['model' => $model->person]);
        });

        $dataTable->addColumn('basic_salary', static function (SalaryReview $model) {
            $value = $model->person->salary - $model->total;

            return Formatter::currency($value, Currency::symbol($model->person->currency));
        });

        $dataTable->rawColumns(array_merge($this->addMonthColumnsToDatatable($dataTable), self::COLUMNS));

        $dataTable->addColumn('total', static function(SalaryReview $model) {
            $value = $model->total;
            $class = $value < 0 ? "red-text" : "";
            $value = Formatter::currency($value, Currency::symbol($model->person->currency));

            return '<span class="'.$class.'">'.$value.'</span>';
        });

        $dataTable->addColumn('salary', static function(SalaryReview $model) {
            $value = $model->person->salary;
            $class = ($value - ($model->person->salary - $model->total)) < 0 ? "red-text" : "";
            $value = Formatter::currency($value, Currency::symbol($model->person->currency));

            return '<span class="'.$class.'">'.$value.'</span>';
        });

        $dataTable->filterColumn('person', static function($query, $keyword) {
            $query->join('people', 'salary_reviews.person_id', '=', 'people.id');
            $query->where('people.name', 'like', "%$keyword%");
        });

        $dataTable->filter(function($query) {
            if ($this->request->has('person_filter')) {
                $query->where('salary_reviews.person_id', '=', $this->request->input('person_filter'));
            }
            if ($this->request->has('reason_filter')) {
                $query->where('salary_reviews.reason', '=', $this->request->input('reason_filter'));
            }
            if ($this->request->has('start_date')) {
                $query->where('invoices.plan_income_date', '>=', \Illuminate\Support\Carbon::parse($this->request->input('start_date'))->startOfMonth());
            }
            if ($this->request->has('end_date')) {
                $query->where('invoices.plan_income_date', '<=', Carbon::parse($this->request->input('end_date'))->endOfMonth());
            }
            if (!$this->request->has('all_people')) {
                $people = Person::whereNull('people.quited_at')
                    ->distinct('people.id')
                    ->pluck('people.id')
                    ->toArray();
                $query->whereIn('person_id', $people);
            }
        }, true);

        $dataTable->orderColumn('person', static function($query, $order) {
            $query->join('people', 'salary_reviews.person_id', '=', 'people.id')
                ->orderBy('people.name', $order);
        });

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param SalaryReview $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    public function query(SalaryReview $model)
    {
        $query = $model->newQuery();

        $query->select('salary_reviews.*');

        $query->with(['person']);

        $this->addMonthsSelect($query);

        $query->whereYear('date', $this->year);
        $query->groupBy('person_id');

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
            ->setTableId('salary-review-list-datatable')
            ->addTableClass('table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
            ->orderBy(1, 'asc')
            ->parameters([
                'columnDefs' => [
                    ['targets' => [1, 2], 'className' => 'small-text'],
                    ['targets' => [3, 6, 9, 12], 'className' => 'small-text border-left center-align'],
                    ['targets' => [4, 7, 10, 13], 'className' => 'small-text center-align'],
                    ['targets' => [5, 8, 11, 14], 'className' => 'small-text border-right center-align'],
                    ['targets' => [15, 16], 'className' => 'small-text center-align'],
                ]
           ]);
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
        $firstColumns[] = Column::make('person');
        $firstColumns[] = Column::make('basic_salary')->orderable(false);

        $monthColumns = $this->monthColumns();

        $secondColumns[] = Column::make('total')->orderable(false);
        $secondColumns[] = Column::make('salary')->orderable(false);

        return array_merge($firstColumns, $monthColumns, $secondColumns);
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
            $dataTable->addColumn($monthName, function(SalaryReview $model) use ($month, $monthName) {
                $value = $model->{$monthName};
                $class = $value < 0 ? "red-text" : "";
                $value = Formatter::currency($value, Currency::symbol($model->person->currency));
                $value = '<span class="'.$class.'">'.$value.'</span>';

                return $model->{$monthName} ? $value : '-';
            });
        }

        return $monthColumns;
    }

    /**
     * @return CarbonPeriod
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    protected function period()
    {
        return CarbonPeriod::create(Carbon::createFromDate($this->year)->startOfYear(), '1 month', Carbon::createFromDate($this->year)->endOfYear());
    }

    /**
     * @return array
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    protected function monthColumns(): array
    {
        $columns = [];

        foreach($this->period() as $month) {
            $columns[] = Column::make(strtolower($month->monthName))
                ->title($month->shortMonthName)
                ->orderable(false)
                ->searchable(false);
        }

        return $columns;
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
            $query->selectRaw("sum(case when month(date)={$month->month} and year(date)='{$this->year}' then sum end) as {$monthName}");
        }
        $query->selectRaw("sum(case when year(date)='{$this->year}' then sum end) as total");
    }
}
