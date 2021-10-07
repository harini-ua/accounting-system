<?php

namespace App\DataTables;

use App\Enums\InvoiceStatus;
use App\Models\Contract;
use App\Models\Invoice;
use App\Services\FilterService;
use App\Services\Formatter;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvoicesDataTable extends DataTable
{
    public const COLUMNS = [
        'number',
        'client',
        'contract',
        'date',
        'wallet',
        'total',
        'status'
    ];

    /** @var FilterService $filterService */
    public $filterService;

    /**
     * ContractsDataTable constructor.
     *
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
        $dataTable = datatables()->eloquent($query);

        $dataTable->addColumn('number', static function(Invoice $model) {
            return '<a target="_blank" href="'.route('invoices.show', $model->id).'">'.$model->number.'</a>';
        });

        $dataTable->addColumn('client', static function (Invoice $model) {
            return view('partials.view-link', ['model' => $model->contract->client]);
        });

        $dataTable->addColumn('contract', static function(Invoice $model) {
            return view('partials.view-link', ['model' => $model->contract]);
        });

        $dataTable->addColumn('wallet', static function(Invoice $model) {
            return view('partials.view-link', ['model' => $model->account->wallet]);
        });

        $dataTable->addColumn('status', static function(Invoice $model) {
            return view('partials.view-status', [
                'status' => InvoiceStatus::getDescription($model->status),
                'color' => InvoiceStatus::getColor($model->status, 'class'),
            ]);
        })->setRowClass(static function (Invoice $model) {
            $class = '';
            if ($model->status === InvoiceStatus::OVERDUE) {
                $class = 'red lighten-5 red-text red-link font-weight-700';
            }

            return $class;
        });

        $dataTable->addColumn('total', static function(Invoice $model) {
            return Formatter::currency($model->total, $model->account->accountType->symbol);
        });

        $dataTable->addColumn('fee', static function(Invoice $model) {
            return Formatter::currency($model->fee, $model->account->accountType->symbol);
        });

        $dataTable->addColumn('received_sum', static function(Invoice $model) {
            return Formatter::currency($model->received_sum, $model->account->accountType->symbol);
        });

        $dataTable->addColumn('action', static function(Invoice $model) {
            return view('partials.actions', ['actions' => ['edit', 'delete'], 'model' => $model]);
        });

        $dataTable->rawColumns(self::COLUMNS);

        $dataTable->filterColumn('number', static function($query, $keyword) {
            $query->where('number', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('client', static function($query, $keyword) {
            $contractIds = Contract::join('clients', 'contracts.client_id', '=', 'clients.id')
                ->where('clients.name', 'like', "%$keyword%")
                ->whereNull('clients.deleted_at')
                ->distinct('contracts.id')
                ->pluck('contracts.id')
                ->toArray();

            $query->whereIn('contract_id', $contractIds);
        });

        $dataTable->filterColumn('contract', static function($query, $keyword) {
            $query->join('contracts', 'invoices.contract_id', '=', 'contracts.id');
            $query->where('contracts.name', 'like', "%$keyword%");
        });

        $dataTable->filter(function($query) {
            if ($this->request->has('start_date')) {
                $query->where('invoices.date', '>=', $this->request->get('start_date'));
            }
            if ($this->request->has('end_date')) {
                $query->where('invoices.date', '<=', $this->request->get('end_date'));
            }
            if ($this->request->has('status_filter')) {
                $query->where('invoices.status', $this->request->get('status_filter'));
            }
            if ($this->request->has('client_filter')) {
                $query->join('clients', 'contracts.client_id', '=', 'clients.id')
                    ->where('clients.id', '=', $this->request->get('client_filter'));
            }
        }, true);

        $dataTable->orderColumn('number', static function($query, $order) {
            $query->orderBy('invoices.id', $order);
        });

        $dataTable->orderColumn('client', static function($query, $order) {
            $query->join('clients', 'contracts.client_id', '=', 'clients.id')
                ->orderBy('clients.name', $order);
        });

        $dataTable->orderColumn('contract', static function($query, $order) {
            $query->orderBy('contracts.name', $order);
        });

        $dataTable->orderColumn('wallet', static function($query, $order) {
            $query->join('accounts', 'accounts.id', '=', 'invoices.account_id')
                ->join('wallets', 'wallets.id', '=', 'accounts.wallet_id')
                ->orderBy('wallets.name', $order);
        });

        $dataTable->orderColumn('total', static function($query, $order) {
            $query->orderBy('invoices.total', $order);
        });

        $dataTable->orderColumn('status', static function($query, $order) {
            $query->orderBy('invoices.status', $order);
        });

        return $dataTable;
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
        $dates = [ $this->filterService->getStartDate(), $this->filterService->getEndDate() ];

        $paymentSums = DB::table('payments')
            ->select('invoice_id', DB::raw('sum(received_sum) as received_sum, sum(fee) as fee'))
            ->whereNull('payments.deleted_at')
            ->whereBetween('payments.date', $dates)
            ->groupBy('invoice_id');

        return $model->with([
                'contract.client', 'account.wallet', 'account.accountType'
            ])
            ->join('contracts', 'contracts.id', '=', 'invoices.contract_id')
            ->leftJoinSub($paymentSums, 'payment_sums', static function($join) {
                $join->on('payment_sums.invoice_id', '=', 'invoices.id');
            })
            ->whereBetween('invoices.created_at', $dates)
            ->select([
                'invoices.*',
                'payment_sums.fee as fee',
                'payment_sums.received_sum as received_sum'
            ])->newQuery();
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
            ->setTableId('invoices-list-datatable')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
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
        $data[] = Column::make('number')->title('Invoice #');
        $data[] = Column::make('client');
        $data[] = Column::make('contract');
        $data[] = Column::make('date')->searchable(false);
        $data[] = Column::make('wallet')->searchable(false)->footer(__('Totals: '));
        $data[] = Column::make('total')->title('Sum')->searchable(false);
        $data[] = Column::make('fee')->searchable(false);
        $data[] = Column::make('received_sum')->searchable(false);
        $data[] = Column::make('status')->searchable(false);
        $data[] = Column::computed('action')->addClass('text-center');

        return $data;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Invoices_' . date('YmdHis');
    }
}
