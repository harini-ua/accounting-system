<?php

namespace App\DataTables;

use App\Models\Contract;
use App\Models\Invoice;
use App\Services\FilterService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IncomeListDataTable extends DataTable
{
    public $filterService;

    /**
     * IncomeListDataTable constructor.
     * @param FilterService $filterService
     */
    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

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
                if ($this->request->has('received')) {
                    $query->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('payments')
                            ->whereRaw('payments.invoice_id = invoices.id')
                            ->whereBetween('payments.date', [$this->filterService->getStartDate(), $this->filterService->getEndDate()]);
                    });
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
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Invoice $model)
    {
        $dates = [$this->filterService->getStartOfMonthDate(), $this->filterService->getEndOfMonthDate()];

        $invoiceSums = DB::table('invoice_items')
            ->select('invoice_id', DB::raw('sum(total) as total'))
            ->whereBetween('invoice_items.created_at', $dates)
            ->groupBy('invoice_id');

        $paymentSums = DB::table('payments')
            ->select('invoice_id', DB::raw('sum(received_sum) as received_sum, sum(fee) as fee'))
            ->whereBetween('payments.date', $dates)
            ->groupBy('invoice_id');

        return $model
            ->with([
                'contract.client',
                'account.wallet',
                'salesManager',
//                'account.accountType'
            ])
            ->join('contracts', 'contracts.id', '=', 'invoices.contract_id')
            ->join('invoice_items', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->leftJoinSub($invoiceSums, 'invoice_sums', function($join) {
                $join->on('invoice_sums.invoice_id', '=', 'invoices.id');
            })
            ->leftJoinSub($paymentSums, 'payment_sums', function($join) {
                $join->on('payment_sums.invoice_id', '=', 'invoices.id');
            })
            ->leftJoin('payments', 'payments.invoice_id', '=', 'invoices.id')
            ->select(['invoices.*', 'invoice_sums.total as total'])
            ->selectRaw("payment_sums.fee as fee")
            ->selectRaw("payment_sums.received_sum as received_sum")
            ->groupBy('id')
            ->whereNull('contracts.deleted_at')
            ->where(function($query) use ($dates) {
                $query->whereBetween('payments.date', $dates)
                    ->orWhereBetween('invoice_items.created_at', $dates);
            })
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
            Column::make('id')->searchable(false),
            Column::make('client'),
            Column::make('contract')->searchable(false),
            Column::make('number')->title('Invoice #')->searchable(false),
            Column::make('date')->title('Invoice Date')->searchable(false),
            Column::make('plan_income_date')->title('Planning Date of Income')->searchable(false),
            Column::make('pay_date')->title('Date of Payment')->searchable(false),
            Column::make('wallet')->searchable(false),
//            Column::make('account')->data('account.account_type.name')->searchable(false),
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
