<?php

namespace App\DataTables;

use App\Models\Client;
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
                return '<a href="mailto:'.$model->email.'"><i class="material-icons">email</i> '.$model->email.'</a>';
            })
            ->addColumn('city', static function(Client $model) {
                return $model->billingAddress ? $model->billingAddress->city : null;
            })
            ->addColumn('action', static function(Client $model) {
                return view('partials.actions', ['actions' =>['edit', 'delete'], 'model' => $model]);
            })
            ->orderColumn('city', function($query, $order) {
                $query->join('address', 'address.addressable_id', '=', 'clients.id')
                    ->where('address.addressable_type', Client::class)
                    ->where('address.is_billing', true)
                    ->whereNull('address.deleted_at')
                    ->orderBy('address.city', $order);
            })
            ->rawColumns(self::COLUMNS);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Client $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Client $model)
    {
        return $model->newQuery()->with(['billingAddress']);
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
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
//            ->scrollX(true)
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
        return [
            Column::make('id'),
            Column::make('name')->searchable(),
            Column::make('company_name')->searchable(),
            Column::make('email'),
            Column::make('city'),
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
