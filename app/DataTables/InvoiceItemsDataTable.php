<?php

namespace App\DataTables;

use App\Models\InvoiceItem;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvoiceItemsDataTable extends DataTable
{
    /**
     * ContractsDataTable constructor.
     */
    public function __construct()
    {
        //
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

        $dataTable->addColumn('action', static function(InvoiceItem $model) {
            return view('partials.actions', ['actions' =>['view', 'edit', 'delete'], 'model' => $model]);
        });

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\InvoiceItem $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(InvoiceItem $model)
    {
        $query = $model->newQuery();

        return $query->with([]);
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
            ->setTableId('invoice-items-list-datatable')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bftrip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
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
        return 'Invoice_Items_' . date('YmdHis');
    }
}
