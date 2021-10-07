<?php

namespace App\DataTables;

use App\Enums\Currency;
use App\Enums\SalaryReviewProfGrowthType;
use App\Enums\SalaryReviewReason;
use App\Models\Person;
use App\Models\SalaryReview;
use App\Services\Formatter;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SalaryReviewByPersonDataTable extends DataTable
{
    public const COLUMNS = [
        'person',
        'date',
        'sum',
        'reason',
        'comment',
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
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = datatables()->eloquent($query);

        $dataTable->addColumn('person', static function (SalaryReview $model) {
            return view('partials.view-link', ['model' => $model->person]);
        });

        $dataTable->addColumn('date', static function (SalaryReview $model) {
            return Carbon::parse($model->date)->format(config('general.date.format'));
        });

        $dataTable->addColumn('sum', static function(SalaryReview $model) {
            return Formatter::currency($model->sum, Currency::symbol($model->person->currency));
        });

        $dataTable->addColumn('reason', static function(SalaryReview $model) {
            $reason = SalaryReviewReason::getDescription($model->reason);

            if (($model->reason === SalaryReviewReason::PROFESSIONAL_GROWTH) && $model->prof_growth) {
                $reason .= ' ('.SalaryReviewProfGrowthType::getDescription($model->prof_growth).')';
            }

            return $reason;
        });

        $dataTable->addColumn('comment', static function(SalaryReview $model) {
            return view('partials.text-tooltip', ['text' => $model->comment, 'limit' => 50]);
        });

        $dataTable->addColumn('action', static function(SalaryReview $model) {
            return view('partials.actions', ['actions' => ['edit', 'delete'], 'model' => $model]);
        });

        $dataTable->rawColumns(self::COLUMNS);

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

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param SalaryReview $model
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(SalaryReview $model)
    {
        return $model
            ->with(['person'])
            ->groupBy('person_id')
            ->newQuery();
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
            ->orderBy(0);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns[] = Column::make('id')->hidden();
        $columns[] = Column::make('person');
        $columns[] = Column::make('date');
        $columns[] = Column::make('sum');
        $columns[] = Column::make('reason');
        $columns[] = Column::make('comment');

        $lastColumns[] = Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center');

        return $columns;
    }
}
