<?php

namespace App\DataTables;

use App\Models\Certification;
use App\Services\Formatter;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CertificationsDataTable extends DataTable
{
    const COLUMNS = [
        'person',
        'name',
        'subject',
        'cost',
        'availability',
        'sum_award',
    ];

    /**
     * CertificationsDataTable constructor.
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

        $dataTable->addColumn('person', static function (Certification $model) {
            return view('partials.view-link', ['model' => $model->person]);
        });

        $dataTable->addColumn('name', static function(Certification $model) {
            return Str::limit($model->name);
        });

        $dataTable->addColumn('subject', static function(Certification $model) {
            return Str::limit($model->subject);
        });

        $dataTable->addColumn('cost', static function(Certification $model) {
            return Formatter::currency($model->cost);
        });

        $dataTable->addColumn('availability', static function(Certification $model) {
            return Str::limit($model->availability);
        });

        $dataTable->addColumn('sum_award', static function(Certification $model) {
            return Formatter::currency($model->sum_award);
        });

        $dataTable->addColumn('action', static function(Certification $model) {
            return view('partials.actions', ['actions' => ['edit', 'delete'], 'model' => $model]);
        });

        $dataTable->rawColumns(self::COLUMNS);

        $dataTable->filterColumn('name', static function($query, $keyword) {
            $query->where('name', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('subject', static function($query, $keyword) {
            $query->where('subject', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('availability', static function($query, $keyword) {
            $query->where('availability', 'like', "%$keyword%");
        });

        $dataTable->filter(function($query) {
            if ($this->request->has('person_filter')) {
                $query->where('certifications.person_id', '=', $this->request->input('person_filter'));
            }
        }, true);

        $dataTable->orderColumn('person', static function($query, $order) {
            $query->join('people', 'certifications.person_id', '=', 'people.id')
                ->orderBy('people.name', $order);
        });

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Certification $model
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Certification $model)
    {
        return $model
            ->with(['person'])
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
            ->setTableId('certifications-list-datatable')
            ->addTableClass('table responsive-table highlight')
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
        $data[] = Column::make('id')->hidden();
        $data[] = Column::make('person');
        $data[] = Column::make('name');
        $data[] = Column::make('subject');
        $data[] = Column::make('cost');
        $data[] = Column::make('availability');
        $data[] = Column::make('sum_award');
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
        return 'Certifications_' . date('YmdHis');
    }
}
