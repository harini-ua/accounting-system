<?php

namespace App\DataTables;

use App\Enums\Currency;
use App\Models\Offer;
use App\Services\Formatter;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OffersDataTables extends DataTable
{
    const COLUMNS = [
        'employee',
        'start_date',
        'trial_period',
        'end_trial_period_date',
        'salary',
        'bonuses',
        'salary_review',
        'additional_conditions',
    ];

    /**
     * OffersDataTables constructor.
     */
    public function __construct()
    {
        //..
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

        $dataTable->addColumn('employee', static function (Offer $model) {
            return view('partials.view-link', ['model' => $model->employee]);
        });

        $dataTable->addColumn('start_date', static function (Offer $model) {
            return Carbon::parse($model->start_date)->format(config('general.date.format'));
        });

        $dataTable->addColumn('trial_period', static function (Offer $model) {
            return $model->trial_period.' '.Str::plural('month', $model->trial_period);
        });

        $dataTable->addColumn('end_trial_period_date', static function (Offer $model) {
            return Carbon::parse($model->end_trial_period_date)->format(config('general.date.format'));
        });

        $dataTable->addColumn('salary', static function (Offer $model) {
            return Formatter::currency($model->salary, Currency::symbol($model->employee->currency));
        });

        $dataTable->addColumn('bonuses', static function (Offer $model) {
            return $model->bonuses ? $model->bonuses.'%' : '-';
        });

        $dataTable->addColumn('salary_review', static function (Offer $model) {
            return view('partials.boolean', ['model' => $model, 'field' => 'salary_review']);
        });

        $dataTable->addColumn('additional_conditions', static function (Offer $model) {
            return view('partials.text-tooltip', ['text' => $model->additional_conditions, 'limit' => 50]);
        });

        $dataTable->addColumn('action', static function(Offer $model) {
            return view('partials.actions', ['actions' => ['edit', 'delete'], 'model' => $model]);
        });

        $dataTable->rawColumns(self::COLUMNS);

        $dataTable->filterColumn('employee', static function($query, $keyword) {
            $query->join('people', 'offers.employee_id', '=', 'people.id');
            $query->where('people.name', 'like', "%$keyword%");
        });

        $dataTable->filter(function($query) {
            if ($this->request->has('person_filter')) {
                $query->where('offers.employee_id', '=', $this->request->input('person_filter'));
            }

            if (!$this->request->has('all_employee')) {
                $query->whereNull('people.quited_at');
            }
        }, true);

        $dataTable->orderColumn('start_date', static function($query, $order) {
            $query->orderBy('start_date', $order);
        });

        $dataTable->orderColumn('trial_period', static function($query, $order) {
            $query->orderBy('trial_period', $order);
        });

        $dataTable->orderColumn('end_trial_period_date', static function($query, $order) {
            $query->orderBy('end_trial_period_date', $order);
        });

        $dataTable->orderColumn('salary', static function($query, $order) {
            $query->orderBy('salary', $order);
        });

        $dataTable->orderColumn('bonuses', static function($query, $order) {
            $query->orderBy('bonuses', $order);
        });

        $dataTable->orderColumn('salary_review', static function($query, $order) {
            $query->orderBy('salary_review', $order);
        });

        $dataTable->orderColumn('employee', static function($query, $order) {
            $query->orderBy('people.name', $order);
        });

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Offer $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Offer $model)
    {
        $query = $model->newQuery();
        $query->join('people', 'offers.employee_id', '=', 'people.id');
        $query->select(['offers.*']);

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
            ->setTableId('offers-list-datatable')
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
        $data[] = Column::make('id')->hidden();
        $data[] = Column::make('employee')->title('Employee');
        $data[] = Column::make('start_date')->title('Start Work Date');
        $data[] = Column::make('trial_period')->title('Trial Period');
        $data[] = Column::make('end_trial_period_date')->title('End Trial Period');
        $data[] = Column::make('salary')->title('Salary');
        $data[] = Column::make('bonuses')->title('Bonus');
        $data[] = Column::make('salary_review')->title('Salary Review');
        $data[] = Column::make('additional_conditions')->orderable(false)->title('Additional Conditions');
        $data[] = Column::computed('action')->addClass('text-center');

        return $data;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'OffersDataTables_' . date('YmdHis');
    }
}
