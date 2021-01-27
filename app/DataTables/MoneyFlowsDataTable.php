<?php

namespace App\DataTables;

use App\Models\Account;
use App\Models\MoneyFlow;
use App\Services\Formatter;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MoneyFlowsDataTable extends DataTable
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
            ->addColumn('action', function(MoneyFlow $model) {
                return view("partials.actions", ['actions'=>['edit','delete'], 'model' => $model]);
            })
            ->addColumn('comment', function(MoneyFlow $model) {
                return mb_strimwidth($model->comment, 0, 50, '...');
            })
            ->addColumn('sum_from', function(MoneyFlow $model) {
                return Formatter::currency($model->sum_from, $model->accountFrom->accountType->symbol);
            })
            ->addColumn('sum_to', function(MoneyFlow $model) {
                return Formatter::currency($model->sum_to, $model->accountTo->accountType->symbol);
            })
            ->addColumn('fee', function(MoneyFlow $model) {
                return Formatter::currency($model->fee, $model->accountFrom->accountType->symbol);
            })
            ->filterColumn('wallet_from', function($query, $keyword) {
                $accounts = Account::join('wallets', 'wallets.id', '=', 'accounts.wallet_id')
                    ->where('wallets.name', 'like', "%$keyword%")
                    ->pluck('accounts.id')
                    ->toArray();
                $query->whereIn('account_from_id', $accounts);
            })
            ->filterColumn('wallet_to', function($query, $keyword) {
                $accounts = Account::join('wallets', 'wallets.id', '=', 'accounts.wallet_id')
                    ->where('wallets.name', 'like', "%$keyword%")
                    ->pluck('accounts.id')
                    ->toArray();
                $query->whereIn('account_to_id', $accounts);
            })
            ->orderColumn('sum_from', function($query, $order) {
                $query->orderBy('sum_from', $order);
            })
            ->orderColumn('sum_to', function($query, $order) {
                $query->orderBy('sum_to', $order);
            })
            ->orderColumn('fee', function($query, $order) {
                $query->orderBy('fee', $order);
            })
            ->orderColumn('wallet_from', function($query, $order) {
                $query->join('accounts', 'accounts.id', '=', 'money_flows.account_from_id')
                    ->join('wallets', 'wallets.id', '=', 'accounts.wallet_id')
                    ->orderBy('wallets.name', $order);
            })
            ->orderColumn('wallet_to', function($query, $order) {
                $query->join('accounts', 'accounts.id', '=', 'money_flows.account_to_id')
                    ->join('wallets', 'wallets.id', '=', 'accounts.wallet_id')
                    ->orderBy('wallets.name', $order);
            })
            ->orderColumn('date', function($query, $order) {
                $query->orderBy('money_flows.date', $order);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\MoneyFlow $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MoneyFlow $model)
    {
        return $model
            ->newQuery()
            ->with([
                'accountFrom.wallet',
                'accountFrom.accountType',
                'accountTo.wallet',
                'accountTo.accountType'
            ]);
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
            ->setTableId('moneyflows-table')
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
            Column::make('date'),
            Column::make('wallet_from')->data('account_from.wallet.name'),
            Column::make('sum_from'),
            Column::make('wallet_to')->data('account_to.wallet.name'),
            Column::make('sum_to'),
            Column::make('currency_rate'),
            Column::make('fee'),
            Column::make('comment'),
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
        return 'MoneyFlows_' . date('YmdHis');
    }
}
