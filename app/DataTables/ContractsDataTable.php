<?php

namespace App\DataTables;

use App\Enums\ContractStatus;
use App\Modules\Contract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContractsDataTable extends DataTable
{
    const COLUMNS = [
        'id',
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
        $dataTable->addColumn('id', static function(Contract $model) {
            return $model->id;
        });

        if ($this->client_id === null) {
            $dataTable->addColumn('client', static function(Contract $model) {
                return '<a target="_blank" href="'.route('clients.show', $model->client->id).'">'.$model->client->name.'</a>';
            });
        }

        $dataTable->addColumn('name', function(Contract $model) {
            return '<a target="_blank" href="'.route('contracts.show', $model->id).'">'.$model->name.'</a>';
        });

        $dataTable->addColumn('comment', function(Contract $model) {
            return mb_strimwidth($model->comment, 0, 50, '...');
        });

        $dataTable->addColumn('status', static function(Contract $model) {
            switch ($model->status) {
                case ContractStatus::CLOSED:
                    return '<span class="chip lighten-5 red red-text">'.
                        ContractStatus::getDescription($model->status).'</span>';
                case ContractStatus::OPENED:
                default:
                    return '<span class="chip lighten-5 green green">'.
                        ContractStatus::getDescription($model->status).'</span>';
            }
        });

        $dataTable->addColumn('manager', static function(Contract $model) {
            return $model->manager->name;
        });

        $dataTable->addColumn('action', static function(Contract $model) {
            return view('partials.actions', ['actions' =>['view', 'edit', 'delete'], 'model' => $model]);
        });

        $dataTable->rawColumns(self::COLUMNS);

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Modules\Contract $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Contract $model)
    {
        $query = $model->newQuery();

        if ($this->client_id !== null) {
            $query->where('client_id', $this->client_id);
        }

        return $query->with(['client', 'manager']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('contracts-list-datatable')
            ->addTableClass('table contract-data-table white border-radius-4 pt-1')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive(true)
            ->dom('<"top display-flex  mb-2"<"action-filters"f><"actions action-btns display-flex align-items-center">><"clear">rt<"bottom"p>')
            ->languageSearch('')
            ->languageSearchPlaceholder('Search Contract')
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

        if ($this->client_id === null) {
            $data[] = Column::make('client');
        }

        $data[] = Column::make('name')->searchable();
        $data[] = Column::make('comment');
        $data[] = Column::make('manager')->title(__('Sales Manager'));
        $data[] = Column::make('status');
        $data[] = Column::computed('action')->addClass('text-center');

//        dump($data);
//        die('dump');

        return $data;
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
