<?php

namespace App\DataTables;

use App\Models\Contract;
use App\Models\Income;
use App\Services\FilterService;
use App\Services\Formatter;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Carbon;

class IncomesDataTable extends DataTable
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
            ->addColumn('plan_sum', function(Income $model) {
                return Formatter::currency($model->plan_sum, $model->account->accountType->symbol);
            })
            ->addColumn('client', function(Income $model) {
                return view('partials.view-link', ['model' => $model->contract->client]);
            })
            ->addColumn('contract', function(Income $model) {
                return view('partials.view-link', ['model' => $model->contract]);
            })
            ->addColumn('wallet', function(Income $model) {
                return view('partials.view-link', ['model' => $model->account->wallet]);
            })
            ->filter(function($query) {
                if ($this->request->has('client_filter')) {
                    $filter = $this->request->input('client_filter');
                    $contracts = Contract::join('clients', 'contracts.client_id', '=', 'clients.id')
                        ->where('clients.id', '=', $filter)
                        ->whereNull('clients.deleted_at')
                        ->distinct('contracts.id')
                        ->pluck('contracts.id')
                        ->toArray();
                    $query->whereIn('contract_id', $contracts);
                }
            }, true)
            ->filterColumn('client', function($query, $keyword) {
                $contracts = Contract::join('clients', 'contracts.client_id', '=', 'clients.id')
                    ->where('clients.name', 'like', "%$keyword%")
                    ->whereNull('clients.deleted_at')
                    ->distinct('contracts.id')
                    ->pluck('contracts.id')
                    ->toArray();
                $query->whereIn('contract_id', $contracts);
            })
            ->orderColumn('plan_sum', function($query, $order) {
                $query->orderBy('plan_sum', $order);
            })
            ->orderColumn('client', function($query, $order) {
                $query->join('contracts', 'contracts.id', '=', 'incomes.contract_id')
                    ->join('clients', 'contracts.client_id', '=', 'clients.id')
                    ->orderBy('clients.name', $order);
            })
            ->orderColumn('contract', function($query, $order) {
                $query->join('contracts', 'contracts.id', '=', 'incomes.contract_id')
                    ->orderBy('contracts.name', $order);
            })
            ->orderColumn('wallet', function($query, $order) {
                $query->join('accounts', 'accounts.id', '=', 'incomes.account_id')
                    ->join('wallets', 'wallets.id', '=', 'accounts.wallet_id')
                    ->orderBy('wallets.name', $order);
            })
            ->orderColumn('account', function($query, $order) {
                $query->join('accounts', 'accounts.id', '=', 'incomes.account_id')
                    ->join('account_types', 'account_types.id', '=', 'accounts.account_type_id')
                    ->orderBy('account_types.name', $order);
            })
            ->orderColumn('plan_date', function($query, $order) {
                $query->orderBy('plan_date', $order);
            })
            ->addColumn('action', function(Income $account) {
                return view("partials.actions", ['actions'=>['edit', 'delete'], 'model' => $account]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Income $model
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Income $model)
    {
        return $model
            ->with(['contract.client', 'account.wallet', 'account.accountType'])
            ->whereBetween('plan_date', [$this->filterService->getStartOfMonthDate(), $this->filterService->getEndOfMonthDate()])
            ->newQuery();
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
            ->setTableId('incomes-table')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
            ->languageSearch('Search')
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
            Column::make('wallet')->searchable(false),
            Column::make('account')->data('account.account_type.name')->searchable(false),
            Column::make('plan_sum')->searchable(false),
            Column::make('plan_date')->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
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
        return 'Incomes_' . date('YmdHis');
    }
}
