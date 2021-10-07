<?php

namespace App\DataTables;

use App\Enums\ContractStatus;
use App\Models\Contract;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ContractsDataTable extends DataTable
{
    public const COLUMNS = [
        'id',
        'contract',
        'client',
        'name',
        'comment',
        'manager',
        'status'
    ];

    /** @var int|null $client_id */
    public $client_id;

    /**
     * ContractsDataTable constructor.
     *
     * @param integer|null $client_id
     */
    public function __construct($client_id = null)
    {
        $this->client_id = $client_id;
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

        $dataTable->addColumn('name', static function(Contract $model) {
            return view('partials.view-link', ['model' => $model]);
        });

        if ($this->client_id === null) {
            $dataTable->addColumn('client', static function(Contract $model) {
                return view('partials.view-link', ['model' => $model->client]);
            });
        }

        $dataTable->addColumn('comment', static function(Contract $model) {
            return mb_strimwidth($model->comment, 0, 50, '...');
        });

        $dataTable->addColumn('manager', static function(Contract $model) {
            return $model->manager->name;
        });

        $dataTable->addColumn('status', static function(Contract $model) {
            return view('partials.view-status', [
                'status' => ContractStatus::getDescription($model->status),
                'color' => ContractStatus::getColor($model->status, 'class'),
            ]);
        });

        $dataTable->addColumn('action', static function(Contract $model) {
            return view('partials.actions', ['actions' =>['edit', 'delete'], 'model' => $model]);
        });

        $dataTable->rawColumns(self::COLUMNS);

        $dataTable->filterColumn('name', static function($query, $keyword) {
            $query->where('contracts.name', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('client', static function($query, $keyword) {
            $contractIds = Contract::join('clients', 'contracts.client_id', '=', 'clients.id')
                ->where('clients.name', 'like', "%$keyword%")
                ->whereNull('clients.deleted_at')
                ->distinct('contracts.id')
                ->pluck('contracts.id')
                ->toArray();

            $query->whereIn('id', $contractIds);
        });

        $dataTable->filter(function($query) {
            if ($this->request->has('client_filter')) {
                $query->where('contracts.client_id', '=', $this->request->input('client_filter'));
            }
            if ($this->request->has('sales_managers_filter')) {
                $query->where('contracts.sales_manager_id', $this->request->get('sales_managers_filter'));
            }
            if ($this->request->has('status_filter')) {
                $query->where('contracts.status', $this->request->input('status_filter'));
            }
        }, true);

        $this->setOrderColumns($dataTable);

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Contract $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Contract $model)
    {
        $query = $model->newQuery();

        $query->with(['client', 'manager']);

        if ($this->client_id !== null) {
            $query->where('client_id', $this->client_id);
        }

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
            ->setTableId('contracts-list-datatable')
            ->addTableClass('subscription-table responsive-table highlight')
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
        $data[] = Column::make('id');
        $data[] = Column::make('name')->searchable(true)->title(__('Contract / Project'));

        if ($this->client_id === null) {
            $data[] = Column::make('client')->searchable(true);
        }

        $data[] = Column::make('comment')->searchable(false)->title(__('Comment'))->orderable(false);
        $data[] = Column::make('manager')->searchable(false)->title(__('Sales Manager'));
        $data[] = Column::make('status')->searchable(false)->title(__('Status'));
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
        $dataTable->orderColumn('contract', static function($query, $order) {
            $query->orderBy('contracts.name', $order);
        });

        $dataTable->orderColumn('client', static function($query, $order) {
            $query->join('clients', 'contracts.client_id', '=', 'clients.id')
                ->orderBy('clients.name', $order);
        });

        $dataTable->orderColumn('manager', static function($query, $order) {
            $query->join('users', 'contracts.sales_manager_id', '=', 'users.id')
                ->orderBy('users.name', $order);
        });

        $dataTable->orderColumn('status', static function($query, $order) {
            $query->orderBy('contracts.status', $order);
        });

        return $dataTable;
    }

    /**
     * @param $query
     */
    private function addFilterQuery($query)
    {
        $query->when($this->request()->input('search.value'), function($query, $search) {
            $query->where('contracts.name', 'like', "%$search%");
        });
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Contracts_' . date('YmdHis');
    }
}
