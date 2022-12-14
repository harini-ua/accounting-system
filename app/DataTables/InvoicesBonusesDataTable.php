<?php

namespace App\DataTables;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\Person;
use App\Services\Formatter;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvoicesBonusesDataTable extends DataTable
{
    public const COLUMNS = [
        'number',
        'date',
        'wallet',
        'bonuses',
        'status'
    ];

    /** @var Person $person */
    public $person;

    /** @var string $year */
    public $year;

    /** @var integer $month */
    public $month;

    /** @var string $currency */
    public $currency;

    /**
     * ContractsDataTable constructor.
     *
     * @param Person $person
     * @param array  $filters
     */
    public function __construct(Person $person, array $filters)
    {
        $this->person = $person;

        $this->year = $filters['year'] ?? null;
        $this->month = $filters['month'] ?? null;
        $this->currency = $filters['currency'] ?? null;
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

        $dataTable->addColumn('fee', static function(Invoice $model) {
            return Formatter::currency($model->fee, $model->account->accountType->symbol);
        });

        $dataTable->addColumn('received_sum', static function(Invoice $model) {
            return Formatter::currency($model->received_sum, $model->account->accountType->symbol);
        });

        $dataTable->addColumn('bonuses', function(Invoice $model) {
            $bonuses = $model->received_sum/100*$this->person->bonuses_reward;
            return Formatter::currency($bonuses, $model->account->accountType->symbol);
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

        $dataTable->rawColumns(self::COLUMNS);

        $dataTable->filter(function($query) {
            if ($this->request->has('year_filter')) {
                $this->year = $this->request->get('year_filter');
                $query->whereYear('invoices.pay_date', $this->year);
            }
            if ($this->request->has('month_filter')) {
                $this->month = $this->request->get('month_filter');
                $query->whereMonth('invoices.pay_date', $this->month);
            }
            if ($this->request->has('currency_filter')) {
                $this->currency = $this->request->get('currency_filter');
                $query->join('accounts', 'accounts.id', '=', 'invoices.account_id');
                $query->join('account_types', 'account_types.id', '=', 'accounts.account_type_id');
                $query->where('account_types.name', $this->currency);
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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Invoice $model)
    {
        $paymentSums = DB::table('payments')
            ->select('invoice_id', DB::raw('sum(received_sum) as received_sum, sum(fee) as fee'))
            ->groupBy('invoice_id');

        $query = $model->newQuery();

        $query->with(['contract.client', 'account.wallet', 'account.accountType']);
        $query->where('invoices.sales_manager_id', $this->person->id);

        $query->join('contracts', 'contracts.id', '=', 'invoices.contract_id');
        $query->leftJoinSub($paymentSums, 'payment_sums', static function($join) {
            $join->on('payment_sums.invoice_id', '=', 'invoices.id');
        });
        $query->select([
            'invoices.*',
            'payment_sums.fee as fee',
            'payment_sums.received_sum as received_sum'
        ]);

        return $query->newQuery();
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
            ->setTableId('bonuses-person-table')
            ->addTableClass('table responsive-table highlight row-border')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->searching(false)
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
        $data[] = Column::make('date');
        $data[] = Column::make('wallet')->footer(__('Totals: '));
        $data[] = Column::make('fee');
        $data[] = Column::make('received_sum');
        $data[] = Column::make('bonuses');
        $data[] = Column::make('status');

        return $data;
    }
}
