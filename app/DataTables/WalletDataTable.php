<?php

namespace App\DataTables;

use App\Wallet;
use App\WalletType;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WalletDataTable extends DataTable
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
            ->addColumn('action', function(Wallet $model) {
                return view("partials.actions", ['actions'=>['view','delete'], 'model' => $model]);
            })
            ->addColumn('status', function(Wallet $model) {
                return $model->status
                    ? '<span class="chip lighten-5 green green-text">Active</span>'
                    : '<span class="chip lighten-5 red red-text">Inactive</span>';
            })
            ->rawColumns(['status'])
            ->filterColumn('type', function($query, $keyword) {
                $walletTypes = WalletType::where('name', 'like', "%$keyword%")->pluck('id')->toArray();
                $query->whereIn('wallet_type_id', $walletTypes);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Wallet $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Wallet $model)
    {
        return $model->newQuery()->with('walletType');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('data-table-wallet')
                    ->addTableClass('display')
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
            Column::make('name'),
            Column::make('type')->data('wallet_type.name'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(60)
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
        return 'Wallet_' . date('YmdHis');
    }
}
