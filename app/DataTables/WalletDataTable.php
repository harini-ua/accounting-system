<?php

namespace App\DataTables;

use App\Models\Wallet;
use App\Models\WalletType;
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
                return view("partials.actions", ['actions'=>['edit','delete'], 'model' => $model]);
            })
            ->addColumn('name', static function(Wallet $model) {
                return view('partials.view-link', ['model' => $model]);
            })
            ->rawColumns(['name'])
            ->filterColumn('type', function($query, $keyword) {
                $walletTypes = WalletType::where('name', 'like', "%$keyword%")->pluck('id')->toArray();
                $query->whereIn('wallet_type_id', $walletTypes);
            })
            ->orderColumn('type', function($query, $order) {
                $query->join('wallet_types', 'wallet_types.id', '=', 'wallets.wallet_type_id')
                    ->orderBy('wallet_types.name', $order);
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
                    ->responsive(true)
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
