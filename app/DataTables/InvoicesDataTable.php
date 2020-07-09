<?php

namespace App\DataTables;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InvoicesDataTable extends DataTable
{
    const COLUMNS = [
        'id',
        'client',
        'number',
        'status'
    ];

    /** @var int|null $contract_id */
    public $contract_id;

    /**
     * ContractsDataTable constructor.
     *
     * @param integer|null $contract_id
     */
    public function __construct($contract_id = null)
    {
        $this->contract_id = $contract_id;
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

        $dataTable->addColumn('client', static function(Invoice $model) {
            return '<a target="_blank" href="'.route('clients.show', $model->client->id).'">'.$model->client->name.'</a>';
        });

        if ($this->contract_id === null) {
            $dataTable->addColumn('contract', static function(Invoice $model) {
                return '<a target="_blank" href="'.route('invoices.show', $model->contract->id).'">'.$model->contract->name.'</a>';
            });
        }

        $dataTable->addColumn('wallet', static function(Invoice $model) {
            return '<a target="_blank" href="'.route('wallets.show', $model->wallet->id).'">'.$model->wallet->name.'</a>';
        });

        $dataTable->addColumn('invoice_date', static function(Invoice $model) {
            return $model->created_at;
        });

        $dataTable->addColumn('status', static function(Invoice $model) {
            $color = InvoiceStatus::getColor($model->status, 'class');
            $class = "chip lighten-5 $color $color-text";
            return '<span class="'.$class.'">'.$model->status.'</span>';
        });

        $dataTable->addColumn('action', static function(Invoice $model) {
            return view('partials.actions', ['actions' =>['view', 'edit', 'delete'], 'model' => $model]);
        });

        $dataTable->rawColumns(self::COLUMNS);

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Invoice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Invoice $model)
    {
        $query = $model->newQuery();

        return $query->with([]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('invoices-list-datatable')
            ->addTableClass('table invoice-data-table white border-radius-4 pt-1')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"top display-flex mb-2"<"action-filters"f><"actions action-btns display-flex align-items-center">><"clear">rt<"bottom"p>')
            ->languageSearch('')
            ->languageSearchPlaceholder('Search Invoice')
            ->orderBy(0);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $data[] = Column::make('id');
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
