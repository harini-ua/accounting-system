<?php

namespace App\DataTables;

use App\Models\Contract;
use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IncomeListDataTable extends DataTable
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
            ->addColumn('client', function(Invoice $model) {
                return view('partials.view-link', ['model' => $model->contract->client]);
            })
            ->addColumn('contract', function(Invoice $model) {
                return view('partials.view-link', ['model' => $model->contract]);
            })
            ->addColumn('wallet', function(Invoice $model) {
                return view('partials.view-link', ['model' => $model->account->wallet]);
            })
            ->addColumn('status', function(Invoice $model) {
                return "<span class='chip lighten-5 green green-text'>{$model->status}</span>";
            })
            ->addColumn('sales', function(Invoice $model) {
                return $model->salesManager->name;
            })
            ->addColumn('created_at', function(Invoice $model) {
                return $model->created_at->format('d-m-Y');
            })
            ->rawColumns(['status'])
            ->filterColumn('client', function($query, $keyword) {
                $contracts = Contract::join('clients', 'contracts.client_id', '=', 'clients.id')
                    ->where('clients.name', 'like', "%$keyword%")
                    ->whereNull('clients.deleted_at')
                    ->distinct('contracts.id')
                    ->pluck('contracts.id')
                    ->toArray();
                $query->whereIn('invoices.contract_id', $contracts);
            })
            ->filter(function($query) {
                if ($this->request->has('client_filter')) {
                    $query->join('clients', 'contracts.client_id', '=', 'clients.id')
                        ->where('clients.id', '=', $this->request->input('client_filter'))
                        ->whereNull('clients.deleted_at');
                }
                if ($this->request->has('wallet_filter')) {
                    $query->join('accounts', 'invoices.account_id', '=', 'accounts.id')
                        ->join('wallets', 'wallets.id', '=', 'accounts.wallet_id')
                        ->where('wallets.id', '=', $this->request->input('wallet_filter'))
                        ->whereNull('wallets.deleted_at')
                        ->whereNull('accounts.deleted_at');
                }
                if ($this->request->has('start_date')) {
                    $query->where('invoices.plan_income_date', '>=', Carbon::parse($this->request->input('start_date'))->startOfMonth());
                }
                if ($this->request->has('end_date')) {
                    $query->where('invoices.plan_income_date', '<=', Carbon::parse($this->request->input('end_date'))->endOfMonth());
                }
            }, true)
            ->orderColumn('client', function($query, $order) {
                $query->join('clients', 'contracts.client_id', '=', 'clients.id')
                    ->orderBy('clients.name', $order);
            })
            ->orderColumn('contract', function($query, $order) {
                $query->orderBy('contracts.name', $order);
            })
            ->orderColumn('sales', function($query, $order) {
                $query->join('users', 'users.id', '=', 'invoices.sales_manager_id')
                    ->orderBy('users.name', $order);
            })
            ->orderColumn('wallet', function($query, $order) {
                $query->join('accounts', 'accounts.id', '=', 'invoices.account_id')
                    ->join('wallets', 'wallets.id', '=', 'accounts.wallet_id')
                    ->orderBy('wallets.name', $order);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Invoice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Invoice $model)
    {
        $planSums = DB::table('incomes')
            ->select('contract_id', DB::raw('sum(plan_sum) as plan_sum'))
            ->groupBy('contract_id');

        return $model
            ->with(['contract.client', 'account.wallet', 'salesManager'])
            ->join('contracts', 'contracts.id', '=', 'invoices.contract_id')
            ->joinSub($planSums, 'plan_sums', function($join) {
                $join->on('invoices.contract_id', '=', 'plan_sums.contract_id');
            })
            ->join('invoice_items', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->join('payments', 'payments.invoice_id', '=', 'invoices.id')
            ->select(['invoices.*', 'plan_sums.plan_sum as plan_sum'])
            ->selectRaw("sum(invoice_items.total) as total")
            ->selectRaw("sum(payments.fee) as fee")
            ->selectRaw("sum(payments.received_sum) as received_sum")
            ->groupBy('id')
            ->whereNull('contracts.deleted_at')
            ->whereNull('invoice_items.deleted_at')
            ->whereNull('payments.deleted_at')
            ->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('incomes-list-table')
            ->addTableClass('table invoice-data-table white border-radius-4 pt-1')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"top display-flex  mb-2"<"action-filters"f><"actions action-btns display-flex align-items-center">><"clear">rt<"bottom"p>')
            ->languageSearch('')
            ->languageSearchPlaceholder('Search by client')
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
            Column::make('id')->searchable(false),
            Column::make('client'),
            Column::make('contract')->searchable(false),
            Column::make('plan_sum')->title('Planning sum')->searchable(false),
            Column::make('number')->title('Invoice #')->searchable(false),
            Column::make('created_at')->title('Invoice Date')->searchable(false),
            Column::make('plan_income_date')->title('Planning Date of Income')->searchable(false),
            Column::make('pay_date')->title('Date of Payment')->searchable(false),
            Column::make('wallet')->searchable(false),
            Column::make('total')->title('Sum')->searchable(false),
            Column::make('fee')->searchable(false),
            Column::make('received_sum')->searchable(false),
            Column::make('status')->searchable(false),
            Column::make('sales')->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'IncomeList_' . date('YmdHis');
    }
}
