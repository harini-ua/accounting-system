<?php

namespace App\DataTables;

use App\Enums\Currency;
use App\Models\Person;
use App\Services\Formatter;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class HiredBonusesDataTable extends DataTable
{
    public const COLUMNS = [
        'name',
        'start_date',
        'salary',
        'bonus',
    ];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = datatables()->eloquent($query);

        $dataTable->addColumn('name', static function(Person $model) {
            return view('partials.view-link', ['model' => $model]);
        });

        $dataTable->addColumn('salary', static function(Person $model) {
            return Formatter::currency($model->salary, Currency::symbol($model->currency));
        });

        $dataTable->addColumn('bonus', static function(Person $model) {
            return Formatter::currency($model->salary, Currency::symbol($model->currency));
        });

        $dataTable->rawColumns(self::COLUMNS);

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param Person $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Person $model)
    {
        return $model->newQuery()
            ->select('people.*');
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
            ->setTableId('person-table')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
            ->orderBy(0, 'desc');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->hidden(),
            Column::make('name')->searchable(),
            Column::make('start_date')->title('Date of the work beginning'),
            Column::make('salary'),
        ];
    }
}