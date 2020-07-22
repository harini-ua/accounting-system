<?php

namespace App\DataTables;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Wallet;
use App\Services\Formatter;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AccountsDataTable extends DataTable
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
            ->addColumn('income', function(Account $account) {
                // todo: calculating income for period
                return 0;
            })
            ->addColumn('expenses', function(Account $account) {
                // todo: calculating expenses for period
                return 0;
            })
            ->addColumn('status', function(Account $model) {
                return $model->status
                    ? '<span class="chip lighten-5 green green-text">Active</span>'
                    : '<span class="chip lighten-5 red red-text">Inactive</span>';
            })
            ->addColumn('balance', function(Account $model) {
                return Formatter::currency($model->balance, $model->accountType);
            })
            ->addColumn('action', function(Account $account) {
                return view("partials.actions", ['actions'=>['edit'], 'model' => $account]);
            })
            ->rawColumns(['status'])
            ->filter(function($query) {
                if ($this->request->has('wallet_filter')) {
                    $wallet_filter = $this->request->input('wallet_filter');
                    $wallets = Wallet::where('id', '=', $wallet_filter)
                        ->whereNull('deleted_at')
                        ->pluck('id')
                        ->toArray();
                    $query->whereIn('wallet_id', $wallets);
                }
            }, true)
            ->filterColumn('wallet', function($query, $keyword) {
                $wallets = Wallet::where('name', 'like', "%$keyword%")
                    ->whereNull('deleted_at')
                    ->pluck('id')
                    ->toArray();
                $query->whereIn('wallet_id', $wallets);
            })
            ->orderColumn('wallet', function($query, $order) {
                $query->join('wallets', 'wallets.id', '=', 'accounts.wallet_id')
                    ->orderBy('wallets.name', $order);
            })
            ->orderColumn('account', function($query, $order) {
                $query->join('account_types', 'account_types.id', '=', 'accounts.account_type_id')
                    ->orderBy('account_types.name', $order);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Account $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Account $model)
    {
        return $model->newQuery()->with(['wallet', 'accountType']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('accounts-list-datatable')
                    ->addTableClass('subscription-table responsive-table highlight')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0);

//                    -> scrollX(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->searchable(false),
            Column::make('wallet')->data('wallet.name'),
            Column::make('account')->data('account_type.name')->searchable(false),
            Column::make('start_sum')->searchable(false),
            Column::make('income')->searchable(false),
            Column::make('expenses')->searchable(false),
            Column::make('balance')->searchable(false),
            Column::make('status')->searchable(false),
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
        return 'Accounts_' . date('YmdHis');
    }
}
