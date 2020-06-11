<?php

namespace App\DataTables;

use App\Modules\Client;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientsDataTable extends DataTable
{
    const COLUMNS = [
        'name',
        'email',
        'phone'
    ];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('name', static function(Client $model) {
                return '<a target="_blank" href="'.route('clients.show', $model->id).'">'.$model->name.'</a>';
            })
            ->addColumn('email', static function(Client $model) {
                return '<a href="mailto:'.$model->email.'">'.$model->email.'</a>';
            })
            ->addColumn('phone', static function(Client $model) {
                return '<a href="tel:'.$model->phone.'">'.$model->phone.'</a>';
            })
            ->addColumn('action', static function(Client $model) {
                return view('partials.actions', ['actions' =>['edit', 'delete'], 'model' => $model]);
            })
            ->rawColumns(self::COLUMNS);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Modules\Client $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Client $model)
    {
        return $model->newQuery()->with([]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('clients-list-datatable')
            ->addTableClass('table client-data-table white border-radius-4 pt-1')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"top display-flex  mb-2"<"action-filters"f><"actions action-btns display-flex align-items-center">><"clear">rt<"bottom"p>')
            ->languageSearch('')
            ->languageSearchPlaceholder('Search Client')
            ->orderBy(0);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name')->searchable(),
            Column::make('company_name')->searchable(),
            Column::make('email'),
            Column::make('phone'),
            Column::computed('action')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Clients_' . date('YmdHis');
    }
}
