<?php

namespace App\DataTables;

use App\Models\Invoice;
use App\Models\Payment;
use App\Services\Formatter;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PaymentsByInvoiceDataTable extends DataTable
{
    public const COLUMNS = [
        'fee',
        'received_sum',
        'date',
    ];

    /** @var Invoice $invoice */
    public $invoice;

    /**
     * ContractsDataTable constructor.
     *
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
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

        $dataTable->addColumn('date', static function(Payment $model) {
            return Carbon::parse($model->date)->format(config('general.date.format'));
        });

        $dataTable->addColumn('fee', static function(Payment $model) {
            return Formatter::currency($model->fee, $model->invoice->account->accountType->symbol);
        });

        $dataTable->addColumn('received_sum', static function(Payment $model) {
            return Formatter::currency($model->received_sum, $model->invoice->account->accountType->symbol);
        });

        $dataTable->addColumn('action', static function(Payment $model) {
            return view('partials.actions', ['actions' =>['delete'], 'model' => $model]);
        });

        $dataTable->rawColumns(self::COLUMNS);

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Payment $model
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Payment $model)
    {
        return $model->with(['invoice.account.accountType'])
            ->where('invoice_id', $this->invoice->id)
            ->orderBy('date', 'desc')
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
            ->setTableId('payments-list-datatable')
            ->addTableClass('table responsive-table highlight')
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
        $data[] = Column::make('date');
        $data[] = Column::make('fee');
        $data[] = Column::make('received_sum');
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
        return 'Payments_' . date('YmdHis');
    }
}
