<?php

namespace App\DataTables;

use App\Enums\InvoiceStatus;
use App\Models\Contract;
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
        'number',
        'client',
        'contract',
        'date',
        'wallet',
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
            return view('partials.view-link', ['model' => $model->contract->client]);
        });

        if ($this->contract_id === null) {
            $dataTable->addColumn('contract', static function(Invoice $model) {
                return view('partials.view-link', ['model' => $model->contract]);
            });
        }

        $dataTable->addColumn('wallet', static function(Invoice $model) {
            return view('partials.view-link', ['model' => $model->account->wallet]);
        });

        $dataTable->addColumn('status', static function(Invoice $model) {
            return view('partials.view-status', [
                'model' => $model,
                'color' => InvoiceStatus::getColor($model->status, 'class'),
            ]);
        });

        $dataTable->addColumn('action', static function(Invoice $model) {
            return view('partials.actions', ['actions' => ['view', 'edit', 'delete'], 'model' => $model]);
        });

        $dataTable->rawColumns(self::COLUMNS);

        $dataTable->filterColumn('client', static function($query, $keyword) {
            $contractIds = Contract::join('clients', 'contracts.client_id', '=', 'clients.id')
                ->where('clients.name', 'like', "%$keyword%")
                ->whereNull('clients.deleted_at')
                ->distinct('contracts.id')
                ->pluck('contracts.id')
                ->toArray();

            $query->whereIn('contract_id', $contractIds);
        });

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

        return $query->with(['contract.client', 'account.wallet'])
            ->join('contracts', 'contracts.id', '=', 'invoices.contract_id')
            ->select(['invoices.*'])
            ;
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
            ->languageSearchPlaceholder(__('Search By Client'))
            ->scrollX(true)
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
        $data[] = Column::make('number')->title('Invoice #');
        $data[] = Column::make('client');
        $data[] = Column::make('contract')->searchable(false);
        $data[] = Column::make('date')->searchable(false);
        $data[] = Column::make('wallet')->searchable(false);
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
