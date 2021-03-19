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
    public const COLUMNS = [
        'client_name',
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
        $dataTable = datatables()->eloquent($query);

        $dataTable->addColumn('client_name', static function(Client $model) {
            return '<a target="_blank" href="'.route('clients.show', $model->id).'">'.$model->name.'</a>';
        });

        $dataTable->addColumn('email', static function(Client $model) {
            return '<a href="mailto:'.$model->email.'">'.$model->email.'</a>';
        });

        $dataTable->addColumn('city', static function(Client $model) {
            return $model->billingAddress ? $model->billingAddress->city : null;
        });

        $dataTable->addColumn('action', static function(Client $model) {
            return view('partials.actions', ['actions' => ['edit', 'delete'], 'model' => $model]);
        });

        $dataTable->orderColumn('client_name', static function($query, $order) {
            $query->orderBy('name', $order);
        });

        $dataTable->orderColumn('email', static function($query, $order) {
            $query->orderBy('email', $order);
        });

        $dataTable->orderColumn('city', function($query, $order) {
            $query->join('address', 'address.addressable_id', '=', 'clients.id')
                ->where('address.addressable_type', Client::class)
                ->where('address.is_billing', true)
                ->whereNull('address.deleted_at')
                ->orderBy('address.city', $order);
        });

        $dataTable->rawColumns(self::COLUMNS);

        return $dataTable;
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
     * @throws \Throwable
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('clients-list-datatable')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->pageLength(15)
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
            Column::make('name')->hidden()->searchable(true),
            Column::make('client_name'),
            Column::make('company_name')->searchable(true),
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
