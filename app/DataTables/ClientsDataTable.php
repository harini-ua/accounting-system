<?php

namespace App\DataTables;

use App\Modules\Client;
use App\Position;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientsDataTable extends DataTable
{
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
            ->rawColumns(['name', 'email', 'phone'])
            ->addColumn('action', static function(Client $client) {
                return view('partials.actions', ['actions' =>['view', 'edit', 'delete'], 'model' => $client]);
            });
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
                    ->addTableClass('table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
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
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(100)
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
