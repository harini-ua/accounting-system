<?php

namespace App\DataTables;

use App\Enums\Currency;
use App\Enums\PersonContractType;
use App\Enums\Position;
use App\Models\Person;
use App\Services\Formatter;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FormerPersonDataTable extends DataTable
{
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

            // definitions
            ->addColumn('name', function(Person $model) {
                return view('partials.view-link', ['model' => $model]);
            })
            ->addColumn('position', function(Person $model) {
                return Position::getDescription($model->position_id);
            })
            ->addColumn('contract_type', function(Person $model) {
                return PersonContractType::getDescription($model->contract_type);
            })
            ->addColumn('salary', function(Person $model) {
                return Formatter::currency($model->salary, Currency::symbol($model->currency));
            })

            // filters
            ->filterColumn('name', function($query, $keyword) {
                $query->where('name', 'like', "%$keyword%");
            })

            // orders
            ->orderColumn('name', function($query, $order) {
                $query->orderBy('name', $order);
            })
            ->orderColumn('position', function($query, $order) {
                $query->orderBy('position_id', $order);
            })
            ->orderColumn('contract_type', function($query, $order) {
                $query->orderBy('contract_type', $order);
            })
            ->orderColumn('salary', function($query, $order) {
                $query->orderBy('salary', $order);
            })
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param Person $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Person $model)
    {
        return $model
            ->whereNotNull('quited_at')
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
                    ->setTableId('formerperson-table')
                    ->addTableClass('subscription-table responsive-table highlight')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip');
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
            Column::make('name')->searchable(),
            Column::make('position'),
            Column::make('start_date')->title('Date of the work beginning'),
            Column::make('quited_at')->title('Date of the work ending'),
            Column::make('salary'),
            Column::make('contract_type')->title('Type of contract'),
            Column::make('quit_reason')->title('Reason for the job quit'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'FormerPerson_' . date('YmdHis');
    }
}
