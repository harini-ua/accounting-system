<?php

namespace App\DataTables;

use App\Models\FinalPayslip;
use App\Services\FilterService;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FinalPayslipDataTable extends DataTable
{
    public const COLUMNS = [
        'employee',
        'paid',
        'last_working_day',
        'working_days',
        'worked_days',
        'working_hours',
        'worked_hours',
    ];

    /** @var FilterService $filterService */
    public $filterService;

    /**
     * ContractsDataTable constructor.
     *
     * @param FilterService $filterService
     */
    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
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

        $dataTable->addColumn('employee', static function (FinalPayslip $model) {
            return view('partials.view-link', ['model' => $model->employee]);
        });

        $dataTable->addColumn('paid', function(FinalPayslip $model) {
            return view('partials.boolean', ['model' => $model, 'field' => 'paid']);
        });

        $dataTable->addColumn('last_working_day', static function(FinalPayslip $model) {
            return Carbon::parse($model->last_working_day)->format(config('general.date.format'));
        });

        $dataTable->addColumn('action', static function(FinalPayslip $model) {
            return view('partials.actions', ['actions' => ['edit', 'delete'], 'model' => $model]);
        });

        $dataTable->rawColumns(self::COLUMNS);

        $dataTable->filterColumn('employee', static function($query, $keyword) {
            $query->join('people', 'final_payslip.person_id', '=', 'people.id');
            $query->where('people.name', 'like', "%$keyword%");
        });

        $dataTable->filter(function($query) {
            if ($this->request->has('start_date')) {
                $query->where('final_payslip.last_working_day', '>=', \Illuminate\Support\Carbon::parse($this->request->get('start_date'))->startOfMonth());
            }
            if ($this->request->has('end_date')) {
                $query->where('final_payslip.last_working_day', '<=', Carbon::parse($this->request->get('end_date'))->endOfMonth());
            }
            if ($this->request->has('paid')) {
                $query->where('paid', $this->request->get('paid'));
            }
        }, true);

        $this->setOrderColumns($dataTable);

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\FinalPayslip $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FinalPayslip $model)
    {
        $dates = [ $this->filterService->getStartDate(), $this->filterService->getEndDate() ];

        $query = $model->newQuery();
        $query->join('people', 'final_payslip.person_id', '=', 'people.id');
        $query->whereBetween('final_payslip.last_working_day', $dates);
        $query->select([
            'final_payslip.*',
        ]);

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
            ->setTableId('final-payslip-list-datatable')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
            ->orderBy(0)
            ->parameters([
                'columnDefs' => [
                    ['targets' => [1], 'className' => 'small-text border-right'],
                    ['targets' => [2], 'className' => 'small-text border-right center-align'],
                    ['targets' => [3], 'className' => 'small-text border-right center-align'],
                    ['targets' => [4], 'className' => 'small-text border-right center-align'],
                    ['targets' => [5], 'className' => 'small-text border-right center-align'],
                    ['targets' => [6], 'className' => 'small-text center-align'],
                ]
            ]);
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

        $data[] = Column::make('working_days')->title('Working')->orderable(false);
        $data[] = Column::make('worked_days')->title('Worked')->orderable(false);
        $data[] = Column::make('working_hours')->title('Working')->orderable(false);
        $data[] = Column::make('worked_hours')->title('Worked')->orderable(false);

        $data[] = Column::make('last_working_day')->title('Last Day');

        $data[] = Column::make('paid')->title('Paid');
        $data[] = Column::computed('action')->addClass('text-center');

        return $data;
    }

    /**
     * @param $dataTable
     *
     * @return mixed
     */
    protected function setOrderColumns($dataTable)
    {
        $dataTable->orderColumn('employee', static function($query, $order) {
            $query->orderBy('people.name', $order);
        });

        $dataTable->orderColumn('last_working_day', static function($query, $order) {
            $query->orderBy('last_working_day', $order);
        });

        $dataTable->orderColumn('paid', function($query, $order) {
            $query->orderBy('paid', $order);
        });

        return $dataTable;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'FinalPayslip_' . date('YmdHis');
    }
}
