<?php

namespace App\DataTables;

use App\Models\Wallet;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WalletDataTable extends DataTable
{
    public const COLUMNS = [
        'name'
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
            ->addColumn('name', static function(Wallet $model) {
                return view('partials.view-link', ['model' => $model]);
            })
            ->addColumn('action', function(Wallet $model) {
                return view("partials.actions", ['actions'=>['edit','delete'], 'model' => $model]);
            })
            ->rawColumns(self::COLUMNS)
            ->filterColumn('name', function($query, $keyword) {
                $query->where('wallets.name', 'like', "%$keyword%");
            })
            ->orderColumn('name', function($query, $order) {
                $query->orderBy('wallets.name', $order);
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
        return $model->newQuery()
            ->select(['wallets.*'])
            ->with('walletType')
            ;
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
            ->setTableId('data-table-wallet')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->pageLength(16)
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
            ->orderBy(0, 'asc');
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
            Column::make('type')->data('wallet_type.name')->searchable(false),
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
