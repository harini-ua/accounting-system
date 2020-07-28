<?php

namespace App\DataTables;

use App\Enums\InvoiceStatus;
use App\Models\Contract;
use App\Models\Invoice;
use App\Services\Formatter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InvoicesByContractDataTable extends DataTable
{
    public const COLUMNS = [
        'number',
        'date',
        'plan_income_date',
        'wallet',
        'status'
    ];

    /** @var Contract $contract */
    public $contract;

    /**
     * ContractsDataTable constructor.
     *
     * @param Contract $contract
     */
    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
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

        $dataTable->addColumn('wallet', static function(Invoice $model) {
            return view('partials.view-link', ['model' => $model->account->wallet]);
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

        $dataTable->addColumn('status', static function(Invoice $model) {
            return view('partials.view-status', [
                'status' => InvoiceStatus::getDescription($model->status),
                'color' => InvoiceStatus::getColor($model->status, 'class'),
            ]);
        })->setRowClass(static function (Invoice $model) {
            switch ($model->status) {
                case InvoiceStatus::OVERDUE:
                    return 'red lighten-5 red-text red-link font-weight-700';
                    break;
                default:
                    return '';
            }
        });

        $dataTable->addColumn('action', static function(Invoice $model) {
            return view('partials.actions', ['actions' => ['edit', 'delete'], 'model' => $model]);
        });

        $dataTable->rawColumns(self::COLUMNS);

        $dataTable->filter(function($query) {
            if ($this->request->has('client_filter')) {
                $query->join('clients', 'contracts.client_id', '=', 'clients.id')
                    ->where('clients.id', '=', $this->request->input('client_filter'));
            }
            if ($this->request->has('status_filter')) {
                $query->where('invoices.status', $this->request->input('status_filter'));
            }
            if ($this->request->has('start_date')) {
                $query->where('invoices.plan_income_date', '>=', \Illuminate\Support\Carbon::parse($this->request->input('start_date'))->startOfMonth());
            }
            if ($this->request->has('end_date')) {
                $query->where('invoices.plan_income_date', '<=', Carbon::parse($this->request->input('end_date'))->endOfMonth());
            }
        }, true);

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

        $dataTable->orderColumn('status', static function($query, $order) {
            $query->orderBy('invoices.status', $order);
        });

//        $dataTable->with('total_sum', Formatter::currency($query->sum('total'), '$'));
//        $dataTable->with('total_fee', $query->sum('fee'));
//        $dataTable->with('total_received_sum', $query->sum('received_sum'));

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
        $paymentSums = DB::table('payments')
            ->select('invoice_id', DB::raw('sum(received_sum) as received_sum, sum(fee) as fee'))
            ->groupBy('invoice_id');

        return $model->with(['contract.client', 'account.wallet', 'account.accountType'])
            ->where('contract_id', $this->contract->id)
            ->join('contracts', 'contracts.id', '=', 'invoices.contract_id')
            ->leftJoinSub($paymentSums, 'payment_sums', static function($join) {
                $join->on('payment_sums.invoice_id', '=', 'invoices.id');
            })
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
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('invoices-list-datatable ')
            ->addTableClass('table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->searching(false)
            ->dom('Bfrtip')
//            ->footerCallback('function() {
//                var api = this.api();
//                var payload = api.ajax.json();
//                $(api.column(5).footer()).html(payload.total_sum);
//                $(api.column(6).footer()).html(payload.total_fee);
//                $(api.column(7).footer()).html(payload.total_received_sum);
//            }')
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
        $data[] = Column::make('date')->searchable(false);
        $data[] = Column::make('plan_income_date')->searchable(false);
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
