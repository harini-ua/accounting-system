<?php

namespace App\DataTables;

use App\Models\Expense;
use App\Services\FilterService;
use App\Services\Formatter;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ExpenseDataTable extends DataTable
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
            ->addColumn('plan_sum', function(Expense $model) {
                return Formatter::currency($model->plan_sum, $model->account->accountType->symbol);
            })
            ->addColumn('real_sum', function(Expense $model) {
                return Formatter::currency($model->real_sum, $model->account->accountType->symbol);
            })
            ->addColumn('purpose', function(Expense $model) {
                return mb_strimwidth($model->purpose, 0, 50, '...');
            })
            ->addColumn('action', function(Expense $model) {
                return view("partials.actions", ['actions'=>['edit', 'copy', 'delete'], 'model' => $model]);
            })
            ->orderColumn('plan_sum', function($query, $order) {
                $query->orderBy('plan_sum', $order);
            })
            ->orderColumn('real_sum', function($query, $order) {
                $query->orderBy('real_sum', $order);
            })
            ->orderColumn('purpose', function($query, $order) {
                $query->orderBy('purpose', $order);
            })
            ->orderColumn('account', function($query, $order) {
                $query->join('accounts', 'accounts.id', '=', 'expenses.account_id')
                    ->join('account_types', 'account_types.id', '=', 'accounts.account_type_id')
                    ->select(['expenses.id as id', 'expenses.*'])
                    ->orderBy('account_types.name', $order);
            })
            ->orderColumn('wallet', function($query, $order) {
                $query->join('accounts', 'accounts.id', '=', 'expenses.account_id')
                    ->join('wallets', 'wallets.id', '=', 'accounts.wallet_id')
                    ->select(['expenses.id as id', 'expenses.*'])
                    ->orderBy('wallets.name', $order);
            })
            ->orderColumn('category', function($query, $order) {
                $query->join('expense_categories', 'expense_categories.id', '=', 'expenses.expense_category_id')
                    ->select(['expenses.id as id', 'expenses.*'])
                    ->orderBy('expense_categories.name', $order);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Expense $model
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Expense $model)
    {
        return $model
            ->with(['account.wallet', 'account.accountType', 'expenseCategory'])
            ->whereBetween('plan_date', [$this->filterService->getStartDate(), $this->filterService->getEndDate()])
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
                    ->setTableId('expense-datatable-table')
                    ->addTableClass('table responsive-table highlight')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->searching(false)
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
            Column::make('plan_date'),
            Column::make('purpose'),
            Column::make('plan_sum'),
            Column::make('real_sum'),
            Column::make('real_date'),
            Column::make('wallet')->data('account.wallet.name'),
            Column::make('account')->data('account.account_type.name'),
            Column::make('category')->data('expense_category.name'),
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
        return 'Expense_' . date('YmdHis');
    }
}
